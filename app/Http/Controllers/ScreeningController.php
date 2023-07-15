<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreeningRequest;
use App\Http\Requests\UpdateScreeningRequest;
use App\Models\Screening;

class ScreeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Screening::latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScreeningRequest $request): mixed
    {
        $screening = Screening::create([
            'movie_id' => $request->movie_id,
            'screen' => $request->screen,
            'total_seats' => $request->total_seats,
            'date_and_time' => $request->date_and_time,
        ]);

        return $screening->fresh();
    }

    /**
     * Display the specified resource.
     */
    public function show(Screening $screening): Screening
    {
        return $screening;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScreeningRequest $request, Screening $screening)
    {
        $screening->update([
            'movie_id' => $request->movie_id,
            'screen' => $request->screen,
            'total_seats' => $request->total_seats,
            'date_and_time' => $request->date_and_time,
        ]);

        return $screening->fresh();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening): bool
    {
        return $screening->delete();
    }
}
