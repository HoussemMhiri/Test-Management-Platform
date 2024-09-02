<?php

namespace App\Http\Controllers\tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tests\Session\StoreTestSessionRequest;
use App\Http\Requests\Tests\Session\UpdateTestSessionRequest;
use App\Models\TestSession;

class TestsSessionController extends Controller
{
    public function index()
    {
        return view('app.modules.tests.sessions.index');
    }

    public function fetch()
    {
        $authUserId = auth()->id();
        $searchQuery = request('q');
        $paginate = request('paginate', true);
        $perPage = request('perPage', 10);

        $sessions = TestSession::whereHas('test', function ($query) use ($authUserId) {
            $query->where('created_by_user_id', $authUserId);
        })
            ->with(['test' => function ($query) {
                $query->select('id', 'title', 'thumbnail');
            }])
            ->whereHas('test', function ($Subquery) use ($searchQuery) {
                $Subquery->where('title', 'LIKE', "%$searchQuery%");
            })
            ->withCount([
                'invitations',
                'invitations as accepted_invitations_count' => function ($query) {
                    $query->where('status', 'ACCEPTED');
                },
                'userTestAttempts'
            ]);

        if ($paginate === 'false' || $paginate === false) {
            $authUserTestSessions =  $sessions->get();
        } else {
            $authUserTestSessions =  $sessions->paginate($perPage);
        }

        return response()->json([
            'sessions' => $authUserTestSessions
        ], 200);
    }

    public function store(StoreTestSessionRequest $request)
    {
        return response()->json($request->saveTestSession(new TestSession()), 201);
    }

    public function show(TestSession $testSession)
    {
        return response()->json([
            'session' => $testSession
        ], 200);
    }

    public function update(UpdateTestSessionRequest $request, TestSession $testSession)
    {
        return response()->json($request->saveTestSession($testSession), 200);
    }

    public function destroy(TestSession $testSession)
    {
        $testSession->delete();

        return response('', 204);
    }
}
