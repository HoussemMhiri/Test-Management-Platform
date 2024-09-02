<?php

namespace App\Http\Requests\Questions;

use App\Enums\EvaluationEnum;
use App\Enums\QuestionTypeEnum;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Validation\Rule;

trait SaveQuestionTrait
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'text' => ['required'],
            'media_link' => ['nullable', 'url'],
            'evaluation_type' => ['required', Rule::in(EvaluationEnum::values())],
            'type' => ['required', Rule::in(QuestionTypeEnum::values())],
            'order' => [
                'required',
                'integer',
                'gt:0',
                Rule::unique(Question::class, 'order')->where('test_id', $this->route()->parameter('test'))
            ],
            'duration' => ['required', 'integer', 'gt:0'],
            'require_manual_evaluation' => ['required', 'boolean'],
        ];
    }

    public function saveQuestion(Question $question, $test = null)
    {
        $question->fill($this->only([
            'text',
            'media_link',
            'evaluation_type',
            'type',
            'order',
            'duration',
            'require_manual_evaluation'
        ]));

        if ($test) {
            $question->test_id = $test->id;
        }

        $question->save();

        return $question;
    }
}
