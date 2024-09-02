<?php

namespace App\Http\Requests\Tests\Session;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestSessionRequest extends FormRequest
{
    use SaveTestSessionTrait;
}
