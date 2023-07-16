<?php

namespace App\Http\Controllers;

use App\Exceptions\MovieNotFoundException;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Movie::class, 'movie');
    }

    /**
     * Display a listing of the movies.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Movie::paginate(15);
    }

    /**
     * Store a newly created movie in storage.
     *
     * @param  StoreMovieRequest  $request The store movie request.
     * @return Movie The created movie.
     */
    public function store(StoreMovieRequest $request): Movie
    {
        $movie = Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $request->genre,
            'duration' => $request->duration,
            'rating' => $request->rating,
        ]);

        return $movie;
    }

    /**
     * Display the specified movie.
     *
     * @param  int  $movieId The movie ID.
     * @return Movie The specified movie.
     *
     * @throws MovieNotFoundException If the movie is not found.
     */
    public function show(int $movieId): Movie
    {
        $movie = Movie::find($movieId);

        if ($movie) {
            return $movie;
        }

        throw new MovieNotFoundException();
    }

    /**
     * Update the specified movie in storage.
     *
     * @param  UpdateMovieRequest  $request The update movie request.
     * @param  Movie  $movie The movie to update.
     * @return Movie The updated movie.
     *
     * @throws MovieNotFoundException If the movie is not found.
     */
    public function update(UpdateMovieRequest $request, Movie $movie): Movie
    {
        if (! $movie) {
            throw new MovieNotFoundException();
        }

        $movie->update([
            'title' => $request->title,
            'description' => $request->description,
            'genre' => $request->genre,
            'duration' => $request->duration,
            'rating' => $request->rating,
        ]);

        return $movie;
    }

    /**
     * Remove the specified movie from storage.
     *
     * @param  int  $movieId The movie ID.
     * @return bool True if the movie is successfully deleted, false otherwise.
     *
     * @throws MovieNotFoundException If the movie is not found.
     */
    public function destroy(int $movieId): bool
    {
        $movie = Movie::find($movieId);

        if ($movie) {
            return $movie->delete();
        }

        throw new MovieNotFoundException();
    }
}
