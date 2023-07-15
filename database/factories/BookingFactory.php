<?php

namespace Database\Factories;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::where('role', 'USER')->pluck('id');
        $screenings = Screening::pluck('id');

        return [
            'user_id' => $this->faker->randomElement($users),
            'screening_id' => $this->faker->randomElement($screenings),
        ];
    }
}
