<?php

namespace App\Http\Controllers\tests;

use App\Enums\EnumHelpers;
use App\Enums\TestInvitationStatusEnum;
use App\Events\TestUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tests\Invitation\StoreTestInvitationRequest;
use App\Mail\InvitationMail;
use App\Models\Test;
use App\Models\TestInvitation;
use App\Models\TestSession;
use App\Notifications\TestUpdated;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class TestInvitationsController extends Controller
{
    use EnumHelpers;
    public function index()
    {
        return view('app.modules.tests.invitations.index');
    }

    public function fetch()
    {
        $searchQuery = request('q');
        $paginate = request('paginate', true);
        $perPage = request('perPage', 10);
        $testsInvitation = TestInvitation::whereHas('testSession.test', function ($query) use ($searchQuery) {
            $query->where('created_by_user_id', Auth::id());
            if ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%');
            }
        })->with('testSession.test');
        if ($paginate === 'false' || $paginate === false) {
            $authUserTestInvitation = $testsInvitation->get()->map(function ($invit) {
                $data = $invit->toArray();
                $data['status'] = $invit->status->label();
                return $data;
            });
        } else {
            $authUserTestInvitation = $testsInvitation->paginate($perPage);
            $authUserTestInvitation->getCollection()->transform(function ($invit) {
                $data = $invit->toArray();
                $data['status'] = $invit->status->label();
                return $data;
            });
        }
        return response()->json([
            'data' =>  $authUserTestInvitation
        ], 200);
    }

    public function create()
    {
        return view('app.modules.tests.invitations.create');
    }

    public function store(StoreTestInvitationRequest $request)
    {
        return response()->json($request->saveTestInvitation(new TestInvitation()), 201);
    }
    public function update(Request $request, TestInvitation $testInvitation)
    {
        $user = $request->user();

        $request->validate([
            'status' => ['required', Rule::in(TestInvitationStatusEnum::values())],
        ]);

        $data = $request->only([
            "status",
        ]);

        $testInvitation->treated_at = now()->setTimezone('Africa/Tunis');
        $testInvitation->fill($data)->save();

        $user->notify(new TestUpdated($testInvitation));

        return response()->json([
            'data' => $testInvitation
        ]);
    }

    public function resend(TestInvitation $testInvitation)
    {
        $emails =  $testInvitation->email;
        foreach ($emails as $email) {
            Mail::to($email)->send(new InvitationMail($testInvitation));
        }

        return response()->json([
            'email' => $emails
        ]);
    }

    public function destroy(TestInvitation $testInvitation)
    {
        $testInvitation->delete();

        return response('', 204);
    }
}
