<?php

namespace App\Http\Requests\Answers;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
{
    use SaveAnswerTrait;
}
