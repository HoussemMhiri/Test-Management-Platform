<?php

namespace App\Http\Requests\Answers;

use App\Models\Answer;
use Illuminate\Validation\Rule;

trait SaveAnswerTrait
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'text' => ['required'],
            'answer_file' => ['nullable'],
            'correct_value' => ['required'],
            'points' => ['required', 'integer', 'gt:0'],
            'first_place_bonus' => ['integer', 'gte:0'],
            'second_place_bonus' => ['integer', 'gte:0'],
            'third_place_bonus' => ['integer', 'gte:0'],
            'order' => [
                'required',
                'integer',
                'gt:0',
                Rule::unique(Answer::class, 'order')->where('question_id', $this->route()->parameter('question'))
            ],
        ];
    }

    public function saveAnswer(Answer $answer, $question = null)
    {
        $answer->fill($this->only([
            'text',
            'correct_value',
            'points',
            'first_place_bonus',
            'second_place_bonus',
            'third_place_bonus',
            'order',
            'answer_file',
        ]));

        if ($question) {
            $answer->question_id = $question->id;
        }

        $answer->save();

        return $answer;
    }
}
