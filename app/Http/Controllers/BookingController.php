<?php

namespace App\Http\Controllers;

use App\Exceptions\NoSeatsAvailableException;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Screening;
use Illuminate\Routing\Controller;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booking::latest()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request): mixed
    {
        $screening = Screening::where('id', $request->screening_id)->withCount('bookings')->first();

        if ($screening->total_seats > $screening->bookings_count) {

            $booking = Booking::create([
                'screening_id' => $request->screening_id,
                'user_id' => $request->user_id,
            ]);

            return $booking->fresh();
        }
        throw new NoSeatsAvailableException();
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): Booking
    {
        return $booking;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update([
            'movie_id' => $request->movie_id,
            'user_id' => $request->user_id,
        ]);

        return $booking;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking): bool
    {
        return $booking->delete();
    }
}
