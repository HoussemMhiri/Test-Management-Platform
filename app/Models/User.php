<?php

namespace App\Models;

use App\Enums\GenderEnum;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = ['decrypted_password'];

    protected $fillable = [
        'last_name',
        'first_name',
        'country',
        'city',
        'postal_code',
        'governorate',
        'address',
        'gender',
        'phone',
        'username',
        "avatar",
        'email',
        'password',
        'is_admin',
        'subscription_plan_id'

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'gender' => GenderEnum::class,
        'is_admin' => 'boolean',
    ];

    public function createdTests()
    {
        return $this->hasMany(Test::class, 'created_by_user_id');
    }

    public function takenTestsAttempts()
    {
        return $this->hasMany(UserTestAttempt::class);
    }

    /*     public function testsParticipations()
    {
        return $this->hasMany(TestParticipant::class, 'participant_user_id');
    } */

    public function takenTests()
    {
        return $this->belongsToMany(Test::class, 'user_test_attempts');
    }

    public function participantInTests()
    {
        return $this->belongsToMany(Test::class, 'test_participants');
    }

    public function subscriptionPlan()
    {
        return $this->hasOne(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = encrypt($value);
    }

    public function getDecryptedPasswordAttribute()
    {
        return decrypt($this->attributes['password']);
    }
}
