<?php

namespace App\Http\Requests\Tests\Session;

use App\Models\TestSession;
use Illuminate\Validation\Rule;

trait SaveTestSessionTrait
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'status' => ['required'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'test_id' => ['required', Rule::exists('tests', 'id')],
        ];
    }


    public function saveTestSession(TestSession $testSession)
    {
        $data = $this->only([
            'status',
            'start_at',
            'end_at',
            'test_id',
        ]);

        $testSession->fill($data)->save();

        return $testSession;
    }
}
