<?php

namespace App\Models;

use App\Enums\TestVisibilityEnum;
use App\Enums\QuestionSelectionEnum;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'fixed_value',
        'thumbnail',
        'report_background_image',
        'duration',
        'report_margin_top',
        'report_margin_buttom',
        'report_margin_right',
        'report_margin_left',
        'passing_score',
        'question_selection',
        'allowed_attempts_number',
        'window_allowed_crossing_duration',
        'window_crossing_penalties_number',
        'visibility',
        'is_camera_required',
        'is_audio_required',
        'created_by_user_id',
    ];

    protected $casts = [
        'question_selection' => QuestionSelectionEnum::class,
        'visibility' => TestVisibilityEnum::class,
        'is_camera_required' => 'boolean',
        'is_audio_required' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function userTestAttemptsTaken()
    {
        return $this->hasMany(UserTestAttempt::class);
    }

    public function invitations()
    {
        return $this->hasMany(TestInvitation::class);
    }
    public function TestSessionCreated()
    {
        return $this->hasMany(TestSession::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function takenByUsers()
    {
        return $this->belongsToMany(User::class, 'user_test_attempts');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'test_participants');
    }

    public function userTestAttemptsQuestions()
    {
        return $this->belongsToMany(Question::class, 'user_test_attempts');
    }

    public function userTestAttempts()
    {
        return $this->hasManyThrough(UserTestAttempt::class, TestSession::class);
    }

}
