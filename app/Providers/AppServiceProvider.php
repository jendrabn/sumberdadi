<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        // Default pagination style using Bootstrap 4
        Paginator::useBootstrapFive();

        Blade::directive('priceIDR', function ($expression) {
            return "Rp. <?= number_format($expression, 0, ',','.') ?>";
        });
    }
}
