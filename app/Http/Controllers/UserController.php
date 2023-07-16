<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return User::paginate(15);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  StoreUserRequest  $request The store user request.
     * @return User The created user.
     */
    public function store(StoreUserRequest $request): User
    {
        $user = User::create([
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }

    /**
     * Display the specified user.
     *
     * @param  User  $user The user to display.
     * @return User The specified user.
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update the specified user in storage.
     *
     * @param  UpdateUserRequest  $request The update user request.
     * @param  User  $user The user to update.
     * @return User The updated user.
     */
    public function update(UpdateUserRequest $request, User $user): User
    {
        $user->update([
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  User  $user The user to remove.
     * @return bool True if the user is successfully deleted, false otherwise.
     */
    public function destroy(User $user): bool
    {
        return $user->delete();
    }
}
