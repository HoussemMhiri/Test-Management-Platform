<?php

namespace App\Http\Controllers\Exam;

use App\Events\ExamEvent;
use App\Models\TestSession;
use Illuminate\Http\Request;
use App\Models\TestInvitation;
use App\Http\Controllers\Controller;
use App\Models\UserTestAttemptQuestionAnswer;

class ExamsController extends Controller
{
    public function index()
    {
        return view('app.modules.exams.exams');
    }

    public function control()
    {
        return view('app.modules.exams.control');
    }

    public function access(Request $request)
    {
        $accessCode = $request->query('accessCode');

        return view('app.modules.exams.access', ['accessCode' => $accessCode]);
    }

    public function getTestByAccessCode($accessCode)
    {
        $invitation = TestInvitation::where('access_code', $accessCode)->first();

        if (!$invitation) {
            return response()->json(['error' => 'Invitation not found'], 404);
        }

        $testSession = $invitation->testSession;

        if (!$testSession) {
            return response()->json(['error' => 'Test session not found'], 404);
        }

        $testId = $testSession->test_id;

        return response()->json(['test_id' => $testId]);
    }


    public function examEvent(Request $request)
    {
        $examId = $request->query('examId');
        $totalTimeSpent = $request->query('totalTimeSpent');
        $answeredQuestionsCount = $request->query('answeredQuestionsCount');
        $totalTimeRemaining = $request->query('totalTimeRemaining');
        $userTestAttemptId = $request->query('userTestAttemptId');
        $status = $request->query('status');
        $userEmail = $request->query('userEmail');
        $nombreOfQuestion = $request->query('nombreOfQuestion');
        $totalPoints = $request->query('totalPoints');

        event(new ExamEvent($examId, $answeredQuestionsCount, $totalTimeSpent, $totalTimeRemaining, $userTestAttemptId, $status, $nombreOfQuestion, $userEmail, $totalPoints));

        return response()->json(['message' => 'ExamUpdated event emitted']);
    }

    public function getUserTestAttemptAnswers($test_session_id)
    {

        $testSession = TestSession::find($test_session_id);

        if (!$testSession) {
            return response()->json(['message' => 'Test session not found'], 404);
        }

        $userTestAttempts = $testSession->userTestAttempts;

        $result = [];

        foreach ($userTestAttempts as $userTestAttempt) {
            $answers = UserTestAttemptQuestionAnswer::whereHas('userTestAttemptQuestion', function ($query) use ($userTestAttempt) {
                $query->where('user_test_attempt_id', $userTestAttempt->id);
            })->get();

            foreach ($answers as $answer) {
                if (!isset($result[$answer->answer_id])) {
                    $result[$answer->answer_id] = [];
                }
                $result[$answer->answer_id][] = [
                    'user_test_attempt_question_id' => $answer->user_test_attempt_question_id,
                    'answered_at' => $answer->answered_at,
                    'points_earned' => $answer->points_earned,
                ];
            }
        }

        return response()->json($result);
    }
}
