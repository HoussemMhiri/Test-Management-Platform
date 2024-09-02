<?php

namespace App\Http\Requests\Tests\Invitation;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestInvitationRequest extends FormRequest
{
    use SaveTestInvitationTrait;
}
