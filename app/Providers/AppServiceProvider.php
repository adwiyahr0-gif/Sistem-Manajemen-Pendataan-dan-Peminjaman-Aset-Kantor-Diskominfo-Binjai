<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <--- WAJIB DITAMBAHKAN

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
        // Memberitahu Laravel untuk menggunakan styling Bootstrap 5 pada pagination
        Paginator::useBootstrapFive();
    }
}