<?php

namespace App\Http\Controllers\tests;

use Illuminate\Http\Request;
use App\Enums\EnumHelpers;
use App\Http\Controllers\Controller;
use App\Models\UserTestAttempt;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserTestAttemptResultEnum;
use Illuminate\Support\Facades\Validator;

class TestAttemptsController extends Controller
{
    use EnumHelpers;
    public function index()
    {
        return view('app.modules.tests.attempts.index');
    }

    public function fetch()
    {
        $searchQuery = request('q');
        $perPage = request('perPage', 10);
        $testAttempt = UserTestAttempt::whereHas('testSession.test', function ($query) use ($searchQuery) {
            $query->where('created_by_user_id', Auth::id());
            if ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%');
            }
        })
            ->with([
                'testSession' => function ($query) {
                    $query->select('id', 'test_id');
                },
                'testSession.test' => function ($query) {
                    $query->select('id', 'title', 'description', 'thumbnail', 'duration', 'passing_score', 'created_by_user_id');
                },
                'testSession.test.creator' => function ($query) {
                    $query->select('id', 'username', 'email', 'password');
                }
            ])->paginate($perPage);

        /*  $authUserTestsAttempts = $testAttempt
        $authUserTestsAttempts->getCollection()->transform(function ($attempt) {
            $data = $attempt->toArray();
            $data['result'] = $attempt->result->label();
            return $data;
        }); */


        return response()->json([
            'data' =>  $testAttempt
        ], 200);
    }

    public function create()
    {
        return view('app.modules.tests.attempts.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_session_id' => 'required|exists:test_session,id',
            'user_id' => 'required|exists:users,id',
            'current_question_id' => 'nullable|exists:questions,id',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after:start_at',
            'result' => 'required|in:' . implode(',', UserTestAttemptResultEnum::values()),
            'recorded_camera_video_path' => 'nullable|string',
            'recorded_audio_path' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $userTestAttempt = new UserTestAttempt();
        $userTestAttempt->test_session_id = $request->test_session_id;
        $userTestAttempt->user_id = $request->user_id;
        $userTestAttempt->current_question_id = $request->current_question_id;
        $userTestAttempt->start_at = $request->start_at;
        $userTestAttempt->end_at = $request->end_at;
        $userTestAttempt->result = $request->result;
        $userTestAttempt->recorded_camera_video_path = $request->recorded_camera_video_path;
        $userTestAttempt->recorded_audio_path = $request->recorded_audio_path;

        $userTestAttempt->save();

        return response()->json([
            'message' => 'User test attempt created successfully',
            'data' => $userTestAttempt
        ], 201);
    }

    public function destroy(UserTestAttempt $test)
    {
        $test->delete();

        return response('', 204);
    }
}
