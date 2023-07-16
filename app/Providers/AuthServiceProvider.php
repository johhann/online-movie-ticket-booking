<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Movie;
use App\Models\Booking;
use App\Models\Screening;
use App\Policies\UserPolicy;
use App\Policies\MoviePolicy;
use App\Policies\BookingPolicy;
use App\Policies\ScreeningPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Movie::class => MoviePolicy::class,
        Screening::class => ScreeningPolicy::class,
        Booking::class => BookingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $this->registerPolicies();

        Gate::resource('booking', BookingPolicy::class);
    }
}
