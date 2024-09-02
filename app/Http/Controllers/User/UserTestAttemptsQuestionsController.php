<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserTestAttemptQuestion;
use Illuminate\Support\Facades\Validator;

class UserTestAttemptsQuestionsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_test_attempt_id' => 'required|exists:user_test_attempts,id',
            'question_id' => 'required|exists:questions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $userTestAttemptQuestion = new UserTestAttemptQuestion();
        $userTestAttemptQuestion->user_test_attempt_id = $request->user_test_attempt_id;
        $userTestAttemptQuestion->question_id = $request->question_id;

        $userTestAttemptQuestion->save();

        return response()->json([
            'message' => 'User test attempt question created successfully',
            'data' => $userTestAttemptQuestion
        ], 201);
    }
}
