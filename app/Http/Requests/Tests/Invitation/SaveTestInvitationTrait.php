<?php

namespace App\Http\Requests\Tests\Invitation;

use App\Enums\TestInvitationStatusEnum;
use App\Mail\InvitationMail;
use App\Models\TestInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

trait SaveTestInvitationTrait
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email.*' => [
                'required',
                'email',
                Rule::unique('test_invitations', 'email')->where('test_session_id', $this->input('test_session_id'))
            ],
            'status' => ['nullable', Rule::in(TestInvitationStatusEnum::values())],
            'access_code' => [
                'nullable',
                'min:1',
                'max:5',
                'unique:test_invitations,access_code',
                'alpha_num',
            ],
            'test_session_id' => ['required', Rule::exists('test_session', 'id')],
        ];
    }


    public function saveTestInvitation(TestInvitation $testInvitation)
    {
        $data = $this->only([
            'email',
            'status',
            'test_session_id',
        ]) + ['access_code' => generateUniqueRandomCode('test_invitations', 'access_code',)];



        $testInvitation->fill($data)->save();

        $emails = is_array($testInvitation->email) ? $testInvitation->email : explode(',', $testInvitation->email);

        foreach ($emails as $email) {
            $testInvitation = TestInvitation::with('testSession.test')->find($testInvitation->id);
            Mail::to($email)->send(new InvitationMail($testInvitation));
        }

        $testInvitation->unsetRelations();

        return $testInvitation;
    }
}
