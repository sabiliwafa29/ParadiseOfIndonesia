<?php

namespace App\Providers;

use App\Models\Tour;
use App\Observers\TourObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Tour::observe(TourObserver::class);
    }
}
