<?php

namespace App\Http\Controllers\Accept_invitation;

use App\Enums\EnumHelpers;
use App\Enums\TestInvitationStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\TestInvitation;
use App\Models\User;
use App\Notifications\TestUpdated;
use Illuminate\Http\Request;

class AcceptInvitationController extends Controller
{
    use EnumHelpers;
    public function index()
    {
        return view('accept_invitation.index');
    }

    public function update(TestInvitation $testInvitation)
    {

        $testInvitation->status = TestInvitationStatusEnum::ACCEPTED;
        $testInvitation->status->label();
        $testInvitation->treated_at = now()->setTimezone('Africa/Tunis');
        $testInvitation->save();

        $creator = $testInvitation->testSession->test->creator;
        if ($creator) {
            $creator->notify(new TestUpdated($testInvitation));
        }


        return redirect(route('accept_invitation.index'));
    }
}
