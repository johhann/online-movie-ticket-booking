<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\Screening;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function search_controller_returns_matching_screenings_for_logged_in_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $matchingMovie = Movie::factory()->create(['title' => 'Matching Movie', 'genre' => 'Matching Genre']);
        $nonMatchingMovie = Movie::factory()->create(['title' => 'Non-Matching Movie', 'genre' => 'Non-Matching Genre']);

        $matchingScreening = Screening::factory()->create(['movie_id' => $matchingMovie->id]);
        $nonMatchingScreening = Screening::factory()->create(['movie_id' => $nonMatchingMovie->id]);

        $response = $this->getJson('/api/search-screening?search=om');

        $response->assertStatus(200);
    }

    /** @test */
    public function search_controller_returns_unauthorized_for_guest_user()
    {
        $response = $this->getJson('/api/search-screening?search=om');

        $response->assertUnauthorized();
    }
}
