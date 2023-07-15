<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;

class MovieController extends Controller
{
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
    public function show(Movie $movie): Movie
    {
        return $movie;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
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
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): bool
    {
        return $movie->delete();
    }
}
