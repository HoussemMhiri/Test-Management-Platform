<?php

namespace App\Http\Requests\Tests;


use App\Models\Test;
use App\Models\Answer;
use App\Models\Question;
use App\Enums\EvaluationEnum;
use App\Enums\QuestionTypeEnum;
use Illuminate\Validation\Rule;
use App\Enums\TestVisibilityEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use App\Enums\QuestionSelectionEnum;
use Illuminate\Support\Facades\Cache;



trait SaveTestTrait
{
    public abstract function isUpdating();

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $test = $this->route()->parameter('test');
        $testId = $test ? $test->id : null;

        return [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'fixed_value' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'string'],
            'report_background_image' => ['nullable', 'string'],
            'duration' => ['required', 'integer'],
            'report_margin_top' => ['nullable', 'integer', 'gte:0'],
            'report_margin_buttom' => ['nullable', 'integer', 'gte:0'],
            'report_margin_right' => ['nullable', 'integer', 'gte:0'],
            'report_margin_left' => ['nullable', 'integer', 'gte:0'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'passing_score' => ['required', 'integer', 'gt:1'],
            'question_selection' => ['required', Rule::in(QuestionSelectionEnum::values())],
            'allowed_attempts_number' => ['required', 'integer', 'gt:0'],
            'window_allowed_crossing_duration' => ['required', 'integer', 'gte:0'],
            'window_crossing_penalties_number' => ['required', 'integer', 'gte:0'],
            'visibility' => ['required', Rule::in(TestVisibilityEnum::values())],
            'is_camera_required' => ['required', 'boolean'],
            'is_audio_required' => ['required', 'boolean'],
            'questions' => ['required', 'array'],
            'questions.*.id' => [
                'nullable',
                Rule::exists(Question::class, 'id')->where('test_id', $testId)
            ],
            'questions.*.text' => ['required', 'string'],
            'questions.*.media_link' => ['nullable', 'url'],
            'questions.*.evaluation_type' => ['required', Rule::in(EvaluationEnum::values())],
            'questions.*.type' => ['required', Rule::in(QuestionTypeEnum::values())],
            'questions.*.order' => ['required', 'integer', 'gt:0'],
            'questions.*.duration' => ['required', 'integer', 'gt:0'],
            'questions.*.require_manual_evaluation' => ['required', 'boolean'],
            'questions.*.answers' => ['required', 'array'],
            'questions.*.answers.*.id' => [
                'nullable',
                Rule::exists(Answer::class, 'id')->where(function ($query) {
                    return $query->whereHas('question', function ($query) {
                        $testId = $this->route()->parameter('test') ? $this->route()->parameter('test')->id : null;
                        $query->where('test_id', $testId);
                    });
                })
            ],
            'questions.*.answers.*.text' => ['required', 'string'],
            'questions.*.answers.*.correct_value' => ['nullable', 'boolean'],
            'questions.*.answers.*.points' => ['required', 'integer', 'gt:0'],
            'questions.*.answers.*.first_place_bonus' => ['nullable', 'integer', 'gte:0'],
            'questions.*.answers.*.second_place_bonus' => ['nullable', 'integer', 'gte:0'],
            'questions.*.answers.*.third_place_bonus' => ['nullable', 'integer', 'gte:0'],
            'questions.*.answers.*.order' => ['required', 'integer', 'gt:0'],
            'questions.*.answers.*.answer_file' => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $questions = $this->input('questions', []);
            foreach ($questions as $questionIndex => $question) {
                $orders = array_column($question['answers'], 'order');
                if (count($orders) !== count(array_unique($orders))) {
                    $validator->errors()->add("questions.$questionIndex.answers", 'The order of answers must be distinct within each question.');
                }
            }
        });
    }

    public function saveTest(Test $test)
    {
            $this->saveTestGeneralDetails($test);
            $this->saveQuestions($test);
            return $test;
    }

    private function saveTestGeneralDetails(Test $test)
    {
            $data = $this->only([
                'title',
                'description',
                'fixed_value',
                'duration',
                'thumbnail',
                'report_background_image',
                'report_margin_top',
                'report_margin_buttom',
                'report_margin_right',
                'report_margin_right',
                'report_margin_left',
                'start_at',
                'end_at',
                'passing_score',
                'question_selection',
                'allowed_attempts_number',
                'window_allowed_crossing_duration',
                'window_crossing_penalties_number',
                'visibility',
                'is_camera_required',
                'is_audio_required',
            ]) + ['created_by_user_id' => auth()->id()];

            $test->fill($data)->save();


    }

    private function saveQuestions(Test $test)
    {
        $payload_questions = collect($this->input('questions'));

        if ($this->isUpdating()) {
            $payload_questions_ids = $payload_questions->whereNotNull('id')->pluck('id')->toArray();

            $questionsToDelete = $test->questions()->whereNotIn('id', $payload_questions_ids)->get();
            foreach ($questionsToDelete as $question) {
                $question->answers->each(function($answer) {
                    DB::table('user_test_attempt_question_answers')
                        ->where('answer_id', $answer->id)
                        ->delete();
                });

                $question->answers()->delete();
                $question->delete();
            }
        }

        $questions = $payload_questions->map(function ($question) use ($test) {
            return [
                'id' => $question['id'] ?? null,
                'test_id' => $test->id,
                'text' => $question['text'],
                'media_link' => $question['media_link'],
                'evaluation_type' => $question['evaluation_type'],
                'type' => $question['type'],
                'order' => $question['order'],
                'duration' => $question['duration'],
                'require_manual_evaluation' => $question['require_manual_evaluation'],
            ];
        })->toArray();

        Question::upsert(
            $questions,
            ['id'],
            ['test_id', 'text', 'media_link', 'evaluation_type', 'type', 'order', 'duration', 'require_manual_evaluation']
        );

        $updatedQuestions = $test->questions()->get();

        foreach ($payload_questions as $question) {
            $questionObject = $updatedQuestions->firstWhere('text', $question['text']);

            if (!$questionObject) {
                continue;
            }

            $questionId = $questionObject->id;
            $payload_question_answers = collect($question['answers']);

            $payload_question_answers_ids = $payload_question_answers->whereNotNull('id')->pluck('id')->toArray();

            $answersToDelete = Answer::where('question_id', $questionId)->whereNotIn('id', $payload_question_answers_ids)->get();
            foreach ($answersToDelete as $answer) {
                DB::table('user_test_attempt_question_answers')
                    ->where('answer_id', $answer->id)
                    ->delete();

                $answer->delete();
            }

            $answers = $payload_question_answers->map(function ($answer) use ($questionId) {
                return [
                    'id' => $answer['id'] ?? null,
                    'question_id' => $questionId,
                    'text' => $answer['text'],
                    'correct_value' => $answer['correct_value'],
                    'points' => $answer['points'],
                    'first_place_bonus' => $answer['first_place_bonus'],
                    'second_place_bonus' => $answer['second_place_bonus'],
                    'third_place_bonus' => $answer['third_place_bonus'],
                    'order' => $answer['order'],
                    'answer_file' => $answer['answer_file'],
                ];
            })->toArray();

            Answer::upsert(
                $answers,
                ['id'],
                ['question_id', 'text', 'correct_value', 'points', 'first_place_bonus', 'second_place_bonus', 'third_place_bonus', 'order', 'answer_file']
            );
        }
    }

}
