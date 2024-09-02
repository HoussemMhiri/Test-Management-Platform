<?php

namespace App\Models;

use App\Enums\TestInvitationStatusEnum;
use Illuminate\Database\Eloquent\Model;


class TestInvitation extends Model
{
    protected $fillable = [
        'email',
        'status',
        'access_code',
        'treated_at',
        'test_session_id',
    ];

    protected $casts = [
        'email' => "array",
        'status' => TestInvitationStatusEnum::class,
        'treated_at' => 'datetime:Y-m-d H:i'
    ];

    public function testSession()
    {
        return $this->belongsTo(TestSession::class);
    }
}
