<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Logs in a user.
     *
     * @param  LoginRequest  $request The login request.
     * @return User The authenticated user.
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function login(LoginRequest $request): User
    {
        // Find the user by username
        $user = User::where('username', $request->username)->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Generate a new token for the user
            $user['token'] = $user->createToken(config('auth.secret_key'))->plainTextToken;

            return $user;
        }

        // Invalid credentials, abort with 403 error
        abort(403, 'Sorry, the username or password is incorrect.');
    }

    /**
     * Logs out the currently authenticated user.
     */
    public function logout(): \Illuminate\Http\Response
    {
        // Revoke all tokens for the authenticated user
        Auth::user()->tokens()->delete();

        return response(null, 204);
    }

    /**
     * Retrieves the currently authenticated user's profile.
     *
     * @return User The authenticated user.
     */
    public function profile(): User
    {
        return Auth::user();
    }
}
