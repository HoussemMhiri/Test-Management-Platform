<?php

namespace Tests;

use Illuminate\Support\Facades\Gate;
use Database\Factories\UserFactory;
use Laravel\Sanctum\Sanctum;

trait TestHelpers
{
    public function signIn($user = null)
    {
        $user = $user ?: UserFactory::new()->create();

        $this->be($user);

        return $user;
    }

    public function signInSanctum($user = null)
    {
        $user = $user ?: UserFactory::new()->create();

        $token = $user->createToken('token-name'); // Create an API token
        Sanctum::actingAs($user, ['*'], 'sanctum', $token->plainTextToken);

        return $user;
    }

    public function denyPermission($permission)
    {
        Gate::define($permission, function () {
            return false;
        });

        return $this;
    }

    public function allowPermission($permission)
    {
        Gate::define($permission, function (){
            return true;
        });

        return $this;
    }

    public function dumpValidationErrors()
    {
        dd(app('session.store')->get('errors'));
    }

    public function updateLocale($locale)
    {
        app()->setLocale($locale);
        app()->setFallbackLocale($locale);
    }
}
