<?php

namespace Tests\Feature;

use App\Http\Controllers\ScreeningController;
use App\Http\Requests\StoreScreeningRequest;
use App\Http\Requests\UpdateScreeningRequest;
use App\Models\Screening;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ScreeningControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function index_method_returns_paginated_screenings()
    {
        $screenings = Screening::factory()->count(30)->create();
        $response = $this->actingAs(User::factory()->create(['role' => 'ADMIN']))->get('/api/screenings');

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
    }

    /** @test */
    public function store_method_creates_new_screening()
    {
        $user = User::factory()->create(['role' => 'ADMIN']);
        $this->actingAs($user);

        $request = new StoreScreeningRequest([
            'movie_id' => 1,
            'screen' => 'Screen 1',
            'total_seats' => 100,
            'date_and_time' => '2023-07-16 10:00:00',
        ]);

        $response = (new ScreeningController())->store($request);

        $this->assertEquals($request->movie_id, $response->movie_id);
        $this->assertEquals($request->screen, $response->screen);
        $this->assertEquals($request->total_seats, $response->total_seats);
        $this->assertEquals($request->date_and_time, $response->date_and_time);
        $this->assertInstanceOf(Screening::class, $response);
    }

    /** @test */
    public function show_method_returns_requested_screening()
    {
        $screening = Screening::factory()->create();
        $response = $this->actingAs(User::factory()->create(['role' => 'ADMIN']))->get('/api/screenings/'.$screening->id);

        $this->assertEquals($screening->id, $response->json('id'));
        $this->assertInstanceOf(Screening::class, $response->original);
    }

    /** @test */
    public function update_method_updates_requested_screening()
    {
        $screening = Screening::factory()->create();
        $user = User::factory()->create(['role' => 'ADMIN']);
        $this->actingAs($user);

        $newMovieId = 2;
        $newScreen = 'Screen 2';
        $newTotalSeats = 120;
        $newDateAndTime = '2023-07-17 11:00:00';

        $request = new UpdateScreeningRequest([
            'movie_id' => $newMovieId,
            'screen' => $newScreen,
            'total_seats' => $newTotalSeats,
            'date_and_time' => $newDateAndTime,
        ]);

        $response = (new ScreeningController())->update($request, $screening);

        $this->assertEquals($newMovieId, $response->movie_id);
        $this->assertEquals($newScreen, $response->screen);
        $this->assertEquals($newTotalSeats, $response->total_seats);
        $this->assertEquals($newDateAndTime, $response->date_and_time);
        $this->assertInstanceOf(Screening::class, $response);
    }

    /** @test */
    public function destroy_method_deletes_requested_screening()
    {
        $screening = Screening::factory()->create();
        $user = User::factory()->create(['role' => 'ADMIN']);
        $this->actingAs($user);

        $response = (new ScreeningController())->destroy($screening);

        $this->assertTrue($response);
        $this->assertNull(Screening::find($screening->id));
    }
}
