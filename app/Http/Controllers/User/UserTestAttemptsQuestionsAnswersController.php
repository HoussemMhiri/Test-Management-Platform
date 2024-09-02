<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\UserTestAttemptQuestionAnswer;

class UserTestAttemptsQuestionsAnswersController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_test_attempt_question_id' => 'required|exists:user_test_attempt_questions,id',
            'answer_id' => 'required|exists:answers,id',
            'value' => 'nullable|string',
            'points_earned' => 'nullable|integer',
            'answered_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $userTestAttemptQuestionAnswer = new UserTestAttemptQuestionAnswer();
        $userTestAttemptQuestionAnswer->user_test_attempt_question_id = $request->user_test_attempt_question_id;
        $userTestAttemptQuestionAnswer->answer_id = $request->answer_id;
        $userTestAttemptQuestionAnswer->value = $request->value;
        $userTestAttemptQuestionAnswer->points_earned = $request->points_earned;
        $userTestAttemptQuestionAnswer->answered_at = $request->answered_at;

        $userTestAttemptQuestionAnswer->save();

        return response()->json([
            'message' => 'User test attempt question answer created successfully',
            'data' => $userTestAttemptQuestionAnswer
        ], 201);
    }
}
