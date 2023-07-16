<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(100)->create();

        $user = User::where('role', 'USER')->first();
        $user->username = 'user';
        $user->save();

        $admin = User::where('role', 'ADMIN')->first();
        $admin->username = 'admin';
        $admin->save();
    }
}
