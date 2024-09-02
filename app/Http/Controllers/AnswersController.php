<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answers\StoreAnswerRequest;
use App\Http\Requests\Answers\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Question;

class AnswersController extends Controller
{
    public function fetch()
    {
        return response()->json([
            'data' => Answer::all()
        ]);
    }

    public function store(StoreAnswerRequest $request, Question $question)
    {
        return response()->json($request->saveAnswer(new Answer(), $question), 201);
    }

    public function show(Answer $answer)
    {
        return response()->json([
            'data' => $answer
        ], 200);
    }

    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        return response()->json($request->saveAnswer($answer), 200);
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();

        return response('', 204);
    }
}
