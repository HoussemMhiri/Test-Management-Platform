<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestAttemptQuestionAnswer extends Model
{
    protected $fillable = [
        'user_test_attempt_question_id',
        'answer_id',
        'value',
        'points_earned',
        'answered_at',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    public function userTestAttemptQuestion()
    {
        return $this->belongsTo(UserTestAttemptQuestion::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
