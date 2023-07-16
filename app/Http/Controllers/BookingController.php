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
     * Display a listing of the bookings.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Booking::latest()->paginate(15);
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param  StoreBookingRequest  $request The store booking request.
     * @return Booking The created booking.
     *
     * @throws NoSeatsAvailableException If no seats are available for the screening.
     */
    public function store(StoreBookingRequest $request): Booking
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
     * Display the specified booking.
     *
     * @param  Booking  $booking The booking to display.
     * @return Booking The specified booking.
     */
    public function show(Booking $booking): Booking
    {
        return $booking;
    }

    /**
     * Update the specified booking in storage.
     *
     * @param  UpdateBookingRequest  $request The update booking request.
     * @param  Booking  $booking The booking to update.
     * @return Booking The updated booking.
     */
    public function update(UpdateBookingRequest $request, Booking $booking): Booking
    {
        $booking->update([
            'movie_id' => $request->movie_id,
            'user_id' => $request->user_id,
        ]);

        return $booking;
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param  Booking  $booking The booking to remove.
     * @return bool True if the booking is successfully deleted, false otherwise.
     */
    public function destroy(Booking $booking): bool
    {
        return $booking->delete();
    }
}
