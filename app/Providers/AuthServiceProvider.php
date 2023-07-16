<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Booking;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\User;
use App\Policies\BookingPolicy;
use App\Policies\MoviePolicy;
use App\Policies\ScreeningPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
