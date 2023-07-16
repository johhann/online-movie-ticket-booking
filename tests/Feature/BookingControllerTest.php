<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\Screening;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Controllers\BookingController;
use App\Http\Requests\UpdateBookingRequest;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\NoSeatsAvailableException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookingControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function index_method_returns_paginated_bookings()
    {
        $bookings = Booking::factory()->count(30)->create();
        $response = $this->actingAs(User::factory()->create(['role' => 'ADMIN']))->get('/api/bookings');

        $response->assertStatus(200);

        $response->assertJsonCount(15, 'data');
    }

    /** @test */
    public function store_method_creates_new_booking_if_seats_available()
    {
        $user = User::factory()->create(['role' => 'ADMIN']);
        $this->actingAs($user);

        $screening = Screening::factory()->create(['total_seats' => 10]);

        $request = new StoreBookingRequest([
            'screening_id' => $screening->id,
            'user_id' => $user->id,
        ]);

        $response = (new BookingController())->store($request);

        $this->assertEquals($request->screening_id, $response->screening_id);
        $this->assertEquals($request->user_id, $response->user_id);
        $this->assertInstanceOf(Booking::class, $response);
    }

    /** @test */
    public function store_method_throws_exception_if_no_seats_available()
    {
        $this->expectException(NoSeatsAvailableException::class);

        $user = User::factory()->create(['role' => 'ADMIN']);
        $this->actingAs($user);

        $screening = Screening::factory()->create(['total_seats' => 0]);

        $request = new StoreBookingRequest([
            'screening_id' => $screening->id,
            'user_id' => $user->id,
        ]);

        (new BookingController())->store($request);
    }

    /** @test */
    public function show_method_returns_requested_booking()
    {
        $booking = Booking::factory()->create();
        $response = $this->actingAs(User::factory()->create(['role' => 'ADMIN']))->get('/api/bookings/'.$booking->id);

        $response->assertStatus(200);
    }



    /** @test */
    public function update_method_updates_requested_booking()
    {
        $booking = Booking::factory()->create();
        $user = User::factory()->create(['role' => 'ADMIN']);
        $this->actingAs($user);

        $newUserId = $user->id;

        $request = new UpdateBookingRequest([
            'user_id' => $newUserId,
        ]);

        $response = (new BookingController())->update($request, $booking);

        $this->assertEquals($newUserId, $response->user_id);
        $this->assertInstanceOf(Booking::class, $response);
    }

    /** @test */
    public function destroy_method_deletes_requested_booking()
    {
        $booking = Booking::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = (new BookingController())->destroy($booking);

        $this->assertTrue($response);
        $this->assertNull(Booking::find($booking->id));
    }
}
