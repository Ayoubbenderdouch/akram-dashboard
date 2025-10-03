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
        // Ensure storage directory exists
        if (!file_exists(storage_path('app/public/products'))) {
            mkdir(storage_path('app/public/products'), 0755, true);
        }
    }
}
