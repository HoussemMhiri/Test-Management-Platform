<?php

namespace App\Models;

use App\Enums\TestSessionEnum;
use Illuminate\Database\Eloquent\Model;

class TestSession extends Model
{

    protected $table = 'test_session';

    protected $fillable = [
        'status',
        'start_at',
        'end_at',
        'test_id',
    ];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d H:i',
        'end_at' => 'datetime:Y-m-d H:i',
        'status' => TestSessionEnum::class,
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function userTestAttempts()
    {
        return $this->hasMany(UserTestAttempt::class);
    }

    public function invitations()
    {
        return $this->hasMany(TestInvitation::class);
    }
}
