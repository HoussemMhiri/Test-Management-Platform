<?php

namespace App\Http\Requests\Answers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnswerRequest extends FormRequest
{
    use SaveAnswerTrait;
}
