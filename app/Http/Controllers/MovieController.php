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
     * Display a listing of the resource.
     */
    public function index()
    {
        return Movie::paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): mixed
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
     * Display the specified resource.
     */
    public function show($movieId): Movie
    {
        $movie = Movie::where('id', $movieId)->first();

        if ($movie) {
            return $movie;
        }

        throw new MovieNotFoundException();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        if (!$movie) {
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

        throw new MovieNotFoundException();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($movieId): bool
    {
        $movie = Movie::where('id', $movieId)->first();

        if ($movie) {
            return $movie->delete();
        }

        throw new MovieNotFoundException();
    }
}
