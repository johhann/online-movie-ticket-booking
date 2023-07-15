<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Screening>
 */
class ScreeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $movies = Movie::pluck('id');

        return [
            'movie_id' => $this->faker->randomElement($movies),
            'screen' => $this->faker->randomElement(['Screen 1', 'Screen 2', 'Screen 3']),
            'total_seats' => $this->faker->numberBetween(50, 100),
            'date_and_time' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
        ];
    }
}
