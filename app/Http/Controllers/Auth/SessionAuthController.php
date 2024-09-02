<?php

namespace App\Http\Controllers\Auth;

use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SessionAuthController extends Controller
{
    public function loginForm()
    {
        session()->flash('login-view', 'register');

        return view('auth.login');
    }

    public function login(Request $request)
    {
        session()->flash('login-view', 'login');

        $user = $request->input('email') ? User::where('email', $request->input('email'))->first() : null;

        $request->validate([
            'email' => ['required', 'email', Rule::exists('users', 'email')],
            'password' => [
                'required',
                function ($attribute, $value, $fail) use ($user, $request) {
                    if ($request->input('email')) {
                        if (!$user || $request->input('password') != $user->decrypted_password) {
                            $fail(trans('users.validation.invalid_credentials'));
                        }
                    }
                }
            ],
        ]);

        Auth::login($user);

        return redirect()->route('app.dashboard');
    }

    public function register(Request $request)
    {
        session()->flash('login-view', 'register');

        $request->validate([
            'last_name' => ['required'],
            'first_name' => ['required'],
            'country' => ['nullable'],
            'city' => ['nullable'],
            'postal_code' => ['nullable'],
            'governorate' => ['nullable'],
            'address' => ['nullable'],
            'gender' => ['nullable',  Rule::in(GenderEnum::values())],
            'phone' => ['nullable', 'string', Rule::unique('users', 'phone')],
            'username' => ['required', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()]
        ]);
        $defaultPlan = SubscriptionPlan::where('is_default_plan', true)->first();
        $userData = $request->only([
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
            'email',
            'password',
        ]);

        $userData['subscription_plan_id'] = $defaultPlan->id;
        $user = User::create($userData);

        Auth::login($user);

        return redirect()->route('app.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
