<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Enums\GenderEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        try {
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
                'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],

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

            $token = $user->createToken('userAccessToken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token,
            ];

            return response()->json(['data' => $response, 'success' => true], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', Rule::exists('users', 'email')],
                'password' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('email')) {
                            $user = User::where('email', $request->input('email'))->first();

                            if (!$user || $request->input('password') !== $user->decrypted_password) {
                                $fail(trans('users.validation.invalid_credentials'));
                            }
                        }
                    }
                ],
            ]);


            $user = User::where('email', $request->input('email'))->first();

            $token = $user->createToken('userAccessToken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token,
            ];

            return response()->json(['data' => $response, 'success' => true], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['success' => true], 200);
    }
}
