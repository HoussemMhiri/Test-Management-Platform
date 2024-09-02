<?php

namespace App\Http\Controllers;

use App\Http\Requests\Questions\StoreQuestionRequest;
use App\Http\Requests\Questions\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\Test;


class QuestionsController extends Controller
{
    public function fetch()
    {
        return response()->json([
            'data' => Question::all()
        ], 200);
    }

    public function store(StoreQuestionRequest $request, Test $test)
    {
        return response()->json($request->saveQuestion(new Question(), $test), 201);
    }

    public function show(Question $question)
    {
        return response()->json([
            'data' => $question
        ], 200);
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        return response()->json($request->saveQuestion($question), 200);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return response('', 204);
    }
}
