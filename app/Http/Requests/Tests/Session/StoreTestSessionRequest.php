<?php

namespace App\Http\Requests\Tests\Session;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestSessionRequest extends FormRequest
{
    use SaveTestSessionTrait;
}
