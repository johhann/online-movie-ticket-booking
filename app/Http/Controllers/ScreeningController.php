<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScreeningRequest;
use App\Http\Requests\UpdateScreeningRequest;
use App\Models\Screening;

class ScreeningController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Screening::class, 'screening');
    }

    /**
     * Display a listing of the screenings.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Screening::latest()->paginate(15);
    }

    /**
     * Store a newly created screening in storage.
     *
     * @param  StoreScreeningRequest  $request The store screening request.
     * @return Screening The created screening.
     */
    public function store(StoreScreeningRequest $request): Screening
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
     * Display the specified screening.
     *
     * @param  Screening  $screening The screening to display.
     * @return Screening The specified screening.
     */
    public function show(Screening $screening): Screening
    {
        return $screening;
    }

    /**
     * Update the specified screening in storage.
     *
     * @param  UpdateScreeningRequest  $request The update screening request.
     * @param  Screening  $screening The screening to update.
     * @return Screening The updated screening.
     */
    public function update(UpdateScreeningRequest $request, Screening $screening): Screening
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
     * Remove the specified screening from storage.
     *
     * @param  Screening  $screening The screening to remove.
     * @return bool True if the screening is successfully deleted, false otherwise.
     */
    public function destroy(Screening $screening): bool
    {
        return $screening->delete();
    }
}
