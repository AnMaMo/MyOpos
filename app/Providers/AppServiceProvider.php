<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia; // Importa la clase Inertia

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
    // Comparte el usuario autenticado en todas las vistas
    Inertia::share('auth.user', function () {
        return auth()->user() ? auth()->user()->only('id', 'name', 'email', 'rol') : null;
    });
    }
}
