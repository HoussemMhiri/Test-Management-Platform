<?php

namespace App\Http\Controllers\tests;

use App\Models\Test;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Tests\StoreTestRequest;
use App\Http\Requests\Tests\UpdateTestRequest;

class TestsController extends Controller
{
    public function getAllTests()
    {
        $tests = Test::with('questions.answers')->get();

        return response()->json(['tests' => $tests]);
    }

    public function index()
    {
        return view('app.modules.tests.index');
    }

    // public function fetch()
    // {
    //     $userAuth = auth()->user();
    public function fetch()
    {
        $userAuth = auth()->user();
        $searchQuery = request('q');
        $paginate = request('paginate', true);
        $perPage = request('perPage', 10);

        $tests = $userAuth->createdTests()
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'LIKE', "%$searchQuery%")
                    ->orWhere('description', 'LIKE', "%$searchQuery%");
            });

        if ($paginate === 'false' || $paginate === false) {
            $authUserTests =  $tests->get();
        } else {
            $authUserTests =  $tests->paginate($perPage);
        }

    //     return response()->json([
    //         'tests' => $userAuth->createdTests()->get()
    //     ], 200);
    // }
        return response()->json([
            'tests' =>  $authUserTests
        ], 200);
    }

    public function show(Test $test)
    {
        return response()->json([
            'data' => $test,
        ], 200);
    }

    public function create()
    {
        return view('app.modules.tests.create');
    }

    public function edit($id)
    {
        $test = Test::findOrFail($id);

        $test->load('questions.answers');

        return view('app.modules.tests.edit', compact('test'));
    }

    public function store(StoreTestRequest $request)
    {
        return response()->json($request->saveTest(new Test()), 201);
    }

    public function update(UpdateTestRequest $request, Test $test)
    {
        return response()->json($request->saveTest($test), 200);
    }

    public function destroy(Test $test)
    {
        $test->delete();

        return response('', 204);
    }

    public function getTest($id)
    {
        $cacheKey = "test_$id";

        $formattedTest = Cache::remember($cacheKey, 60, function () use ($id) {
            $test = Test::with([
                'questions.answers',
                'TestSessionCreated.invitations',
                'userTestAttempts.invitation'
            ])->findOrFail($id);

            return [
                'id' => $test->id,
                'test_id' => $test->id,
                'created_by_user_id' => $test->created_by_user_id,
                'title' => $test->title,
                'description' => $test->description,
                'duration' => $test->duration,
                'passing_score' => $test->passing_score,
                'start_at' => $test->start_at,
                'window_allowed_crossing_duration' => $test->window_allowed_crossing_duration,
                'window_crossing_penalties_number' => $test->window_crossing_penalties_number,
                'test_session' => $test->TestSessionCreated->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'passing_mode' => $session->passing_mode,
                        'invitations' => $session->invitations->map(function ($invitation) {
                            return [
                                'id' => $invitation->id,
                                'email' => $invitation->email,
                                'access_code' => $invitation->access_code,
                                'is_code_used' => $invitation->is_code_used,
                                'status' => $invitation->status,
                            ];
                        })->toArray(),
                    ];
                })->toArray(),
                'user_test_attempts' => $test->userTestAttempts->map(function ($attempt) {
                    return [
                        'id' => $attempt->id,
                        'email' => $attempt->invitation ? $attempt->invitation->email : null,
                        'user_id' => $attempt->user_id,
                        'start_at' => $attempt->start_at,
                        'end_at' => $attempt->end_at,
                        'result' => $attempt->result,
                    ];
                })->toArray(),
                'questions' => $test->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'test_id' => $question->test_id,
                        'text' => $question->text,
                        'type' => $question->type,
                        'media_link' => $question->media_link,
                        'evaluation_type' => $question->evaluation_type,
                        'duration' => $question->duration,
                        'answers' => $question->answers->map(function ($answer) {
                            return [
                                'id' => $answer->id,
                                'text' => $answer->text,
                                'first_place_bonus' => $answer->first_place_bonus,
                                'second_place_bonus' => $answer->second_place_bonus,
                                'third_place_bonus' => $answer->third_place_bonus,
                                'correct_value' => $answer->correct_value,
                                'order' => $answer->order,
                                'points' => $answer->points,
                            ];
                        })->toArray()
                    ];
                })->toArray()
            ];
        });

        return response()->json($formattedTest);
    }

    public function download($testId)
    {
        try {
            $formattedTest = $this->retrieveTestData($testId);

            $html = view('app.modules.tests.print', $formattedTest)->render();

            $downloadPath = storage_path('app/public/test_' . $testId . '.pdf');

            $pdf = Browsershot::html($html)
                ->showBackground()
                ->scale(0.4)
                //->format('A4')
                ->pdf();

            return response($pdf)->header('Content-Type', 'application/pdf');;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate PDF.'], 500);
        }
    }




    public function print($testId)
    {
        $formattedTest = $this->retrieveTestData($testId);

        return view('app.modules.tests.print', $formattedTest);
    }

    private function retrieveTestData($id)
    {
        $cacheKey = "test_$id";

        return Cache::remember($cacheKey, 60, function () use ($id) {
            $test = Test::with(['questions.answers', 'TestSessionCreated'])->findOrFail($id);

            return [
                'id' => $test->id,
                'test_id' => $test->id,
                'created_by_user_id' => $test->created_by_user_id,
                'title' => $test->title,
                'duration' => $test->duration,
                'report_background_image' => $test->report_background_image,
                'report_margin_top' => $test->report_margin_top,
                'report_margin_buttom' => $test->report_margin_buttom,
                'report_margin_right' => $test->report_margin_right,
                'report_margin_left' => $test->report_margin_left,
                'passing_score' => $test->passing_score,
                'test_session' => $test->TestSessionCreated->map(function ($session) {
                    return [
                        'id' => $session->id,
                    ];
                })->toArray(),
                'questions' => $test->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'test_id' => $question->test_id,
                        'text' => $question->text,
                        'type' => $question->type,
                        'media_link' => $question->media_link,
                        'evaluation_type' => $question->evaluation_type,
                        'duration' => $question->duration,
                        'answers' => $question->answers->map(function ($answer) {
                            return [
                                'id' => $answer->id,
                                'text' => $answer->text,
                                'first_place_bonus' => $answer->first_place_bonus,
                                'second_place_bonus' => $answer->second_place_bonus,
                                'third_place_bonus' => $answer->third_place_bonus,
                                'correct_value' => $answer->correct_value,
                                'order' => $answer->order,
                            ];
                        })->toArray()
                    ];
                })->toArray()
            ];
        });
    }
}
