<?php

namespace Tests\Unit\Http\Controllers;

use App\Exceptions\MovieNotFoundException;
use App\Http\Controllers\MovieController;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function index_method_returns_paginated_movies()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Movie::factory()->count(20)->create();
        $response = $this->get('/api/movies');

        $response->assertStatus(200);

        $response->assertJsonCount(15, 'data');
    }

    /** @test */
    public function store_method_creates_new_movie()
    {
        $request = new StoreMovieRequest([
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'genre' => $this->faker->word,
            'duration' => $this->faker->numberBetween(60, 180),
            'rating' => $this->faker->numberBetween(1, 5),
        ]);
        $response = (new MovieController())->store($request);
        $this->assertEquals($request->title, $response->title);
        $this->assertEquals($request->description, $response->description);
        $this->assertEquals($request->genre, $response->genre);
        $this->assertEquals($request->duration, $response->duration);
        $this->assertEquals($request->rating, $response->rating);
        $this->assertInstanceOf(Movie::class, $response);
    }

    /** @test */
    public function show_method_returns_requested_movie()
    {
        $movie = Movie::factory()->create();
        $response = (new MovieController())->show($movie->id);
        $this->assertEquals($movie->id, $response->id);
        $this->assertInstanceOf(Movie::class, $response);
    }

    /** @test */
    public function show_method_throws_exception_if_movie_not_found()
    {
        $this->expectException(MovieNotFoundException::class);
        $id = Movie::max('id');
        (new MovieController())->show($id + 1);
    }

    /** @test */
    public function update_method_updates_requested_movie()
    {
        $movie = Movie::factory()->create();
        $newTitle = $this->faker->sentence;
        $newDescription = $this->faker->paragraph;
        $newGenre = $this->faker->word;
        $newDuration = $this->faker->numberBetween(60, 180);
        $newRating = $this->faker->numberBetween(1, 5);

        $request = new UpdateMovieRequest([
            'title' => $newTitle,
            'description' => $newDescription,
            'genre' => $newGenre,
            'duration' => $newDuration,
            'rating' => $newRating,
        ]);

        $response = (new MovieController())->update($request, $movie);
        $this->assertEquals($newTitle, $response->title);
        $this->assertEquals($newDescription, $response->description);
        $this->assertEquals($newGenre, $response->genre);
        $this->assertEquals($newDuration, $response->duration);
        $this->assertEquals($newRating, $response->rating);
        $this->assertInstanceOf(Movie::class, $response);
    }

    /** @test */
    public function destroy_method_deletes_requested_movie()
    {
        $movie = Movie::factory()->create();
        $response = (new MovieController())->destroy($movie->id);
        $this->assertTrue($response);
        $this->assertNull(Movie::find($movie->id));
    }

    /** @test */
    public function destroy_method_throws_exception_if_movie_not_found()
    {
        $this->expectException(MovieNotFoundException::class);
        (new MovieController())->destroy(Movie::max('id') + 1);
    }
}
