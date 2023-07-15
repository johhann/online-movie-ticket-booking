<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): User
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->where('status', true)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $user['token'] = $user->createToken(config('auth.secret_key'))->plainTextToken;
            return $user;
        }

        abort(403, 'Sorry, the email or password is incorrect.');
    }

    public function logout(Request $request): mixed
    {
        return Auth::user()->tokens()->delete();
    }

    public function profile(Request $request): User
    {
        return Auth::user();
    }
}
