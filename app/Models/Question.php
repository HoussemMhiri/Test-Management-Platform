<?php

namespace App\Models;

use App\Enums\EvaluationEnum;
use App\Enums\QuestionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'test_id',
        'text',
        'media_link',
        'evaluation_type',
        'type',
        'order',
        'duration',
        'require_manual_evaluation',
    ];

    protected $casts = [
        'evaluation_type' => EvaluationEnum::class,
        'type' => QuestionTypeEnum::class,
        'require_manual_evaluation' => 'boolean',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function userTestAttemptQuestions()
    {
        return $this->hasMany(UserTestAttemptQuestion::class);
    }

    public function userTestAttempts()
    {
        return $this->belongsToMany(UserTestAttempt::class);
    }

    public function userTestAttemptsWhereIsCurrent()
    {
        return $this->hasMany(UserTestAttempt::class);
    }
}
