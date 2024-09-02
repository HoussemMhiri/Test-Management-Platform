<?php

namespace App\Http\Requests\Tests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestRequest extends FormRequest
{
    use SaveTestTrait;

    public function isUpdating()
    {
        return true;
    }
}
