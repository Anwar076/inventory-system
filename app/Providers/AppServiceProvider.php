<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

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
        // Schedule the low stock notification command to run every hour
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('inventory:propose-low-stock')
                    ->hourly()
                    ->withoutOverlapping()
                    ->runInBackground();
        });
    }
}
