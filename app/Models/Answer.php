<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'text',
        'correct_value',
        'points',
        'first_place_bonus',
        'second_place_bonus',
        'third_place_bonus',
        'order',
        'answer_file',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userTestAttemptQuestionAnswers()
    {
        return $this->hasMany(UserTestAttemptQuestionAnswer::class);
    }

    public function userTestAttemptQuestions()
    {
        return $this->belongsToMany(UserTestAttemptQuestion::class);
    }
}
