<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\UserController;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function index_method_returns_paginated_users()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        User::factory()->count(20)->create();
        $response = $this->get('/api/users');

        $response->assertStatus(200);

        $response->assertJsonCount(15, 'data');
    }

    /** @test */
    public function store_method_creates_new_user()
    {
        $request = new StoreUserRequest([
            'username' => $this->faker->userName,
            'role' => 'user',
            'password' => $this->faker->password
        ]);
        $response = (new UserController())->store($request);
        $this->assertEquals($request->username, $response->username);
        $this->assertEquals($request->role, $response->role);
        $this->assertTrue(Hash::check($request->password, $response->password));
        $this->assertInstanceOf(User::class, $response);
    }

    /** @test */
    public function show_method_returns_requested_user()
    {
        $user = User::factory()->create();
        $response = (new UserController())->show($user);
        $this->assertEquals($user->id, $response->id);
        $this->assertInstanceOf(User::class, $response);
    }

    /** @test */
    public function update_method_updates_requested_user()
    {
        $user = User::factory()->create();
        $newUsername = $this->faker->userName;
        $newRole = 'admin';
        $newPassword = $this->faker->password;

        $request = new UpdateUserRequest([
            'username' => $newUsername,
            'role' => $newRole,
            'password' => $newPassword
        ]);

        $response = (new UserController())->update($request, $user);
        $this->assertEquals($newUsername, $response->username);
        $this->assertEquals($newRole, $response->role);
        $this->assertTrue(Hash::check($newPassword, $response->password));
        $this->assertInstanceOf(User::class, $response);
    }

    /** @test */
    public function destroy_method_deletes_requested_user()
    {
        $user = User::factory()->create();
        $response = (new UserController())->destroy($user);
        $this->assertTrue($response);
        $this->assertNull(User::find($user->id));
    }
}
