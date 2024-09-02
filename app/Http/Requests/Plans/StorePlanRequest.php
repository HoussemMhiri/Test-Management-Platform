<?php

namespace App\Http\Requests\Plans;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{

    use SavePlanTrait;
}
