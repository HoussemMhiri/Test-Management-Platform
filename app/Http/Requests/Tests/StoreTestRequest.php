<?php

namespace App\Http\Requests\Tests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestRequest extends FormRequest
{
    use SaveTestTrait;

    public function isUpdating()
    {
        return false;
    }
}
