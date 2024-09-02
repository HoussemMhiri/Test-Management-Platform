<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\UserTestAttemptResultEnum;

class UserTestAttempt extends Model
{
    protected $fillable = [
        'test_id',
        'user_id',
        'current_question_id',
        'start_at',
        'end_at',
        'result',
        'recorded_camera_video_path',
        'recorded_audio_path',
    ];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:i',
        'end_at' => 'datetime:Y-m-d H:i',
        'result' => UserTestAttemptResultEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testSession()
    {
        return $this->belongsTo(TestSession::class);
    }

    public function currentQuestion()
    {
        return $this->belongsTo(Question::class, 'current_question_id');
    }

    public function userTestAttemptQuestions()
    {
        return $this->hasMany(UserTestAttemptQuestion::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'user_test_attempt_questions');
    }
}
