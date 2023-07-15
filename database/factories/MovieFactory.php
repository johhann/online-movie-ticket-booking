<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'duration' => $this->faker->numberBetween(60, 180),
            'genre' => $this->faker->randomElement(['Action', 'Comedy', 'Drama', 'Sci-Fi', 'Thriller']),
            'description' => $this->faker->paragraph,
            'rating' => $this->faker->randomFloat(1, 1, 5),
        ];
    }
}
