<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestAttemptQuestion extends Model
{
    protected $fillable = [
        'user_test_attempt_id',
        'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userTestAttempt()
    {
        return $this->belongsTo(UserTestAttempt::class);
    }

    public function answers()
    {
        return $this->hasMany(UserTestAttemptQuestionAnswer::class);
    }
}
