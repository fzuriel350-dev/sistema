<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. Importamos las clases necesarias para los eventos
use App\Events\ProductoGuardado;
use App\Listeners\RegistrarActividad;
use Illuminate\Support\Facades\Event;

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
        // 2. Registramos el evento y su listener
        Event::listen(
            ProductoGuardado::class,
            RegistrarActividad::class,
        );
    }
}
