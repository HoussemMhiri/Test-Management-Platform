<?php

namespace App\Http\Controllers\User;

use App\Enums\EnumHelpers;
use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    use EnumHelpers;
    public function edit()
    {
        return view('app.modules.users.edit');
    }

    public function fetch()
    {
        $authUser = auth()->user();
        return response()->json([
            "user" =>  $authUser
        ], 200);
    }

    public function update(Request $request)
    {
        $user = auth()->user();


        $request->validate([
            'last_name' => ['required'],
            'first_name' => ['required'],
            'country' => ['nullable'],
            'city' => ['nullable'],
            'postal_code' => ['nullable'],
            'governorate' => ['nullable'],
            'address' => ['nullable'],
            'gender' => ['nullable',  Rule::in(GenderEnum::values())],
            'phone' => ['nullable', 'string', Rule::unique('users', 'phone')->ignore($user->id)],
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->id)],
            'avatar' => ['nullable'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['sometimes', 'required', 'min:8']
        ]);

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
            'avatar',
            'email',
            'password',
        ]);


        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $userData['avatar'] = Storage::url($avatarPath);
        }


        $user->fill($userData)->save();


        return response()->json([
            'user' => $user
        ], 200);
    }
}
