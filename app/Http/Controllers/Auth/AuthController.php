<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): User
    {
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $user['token'] = $user->createToken(config('auth.secret_key'))->plainTextToken;

            return $user;
        }

        abort(403, 'Sorry, the username or password is incorrect.');
    }

    public function logout(): mixed
    {
        return Auth::user()->tokens()->delete();
    }

    public function profile(): User
    {
        return Auth::user();
    }
}
