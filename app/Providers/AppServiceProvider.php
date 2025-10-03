<?php

namespace App\Providers;

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
        // Ensure public uploads directory exists
        if (!file_exists(public_path('uploads/products'))) {
            mkdir(public_path('uploads/products'), 0755, true);
        }
    }
}
