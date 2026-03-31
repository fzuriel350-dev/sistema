<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // Comentamos esta línea porque el archivo ya no existe
        // api: __DIR__.'/../routes/api.php', 
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checkRol' => \App\Http\Middleware\CheckRol::class,
        ]);
    })
    ->withEvents(discover: [
        __DIR__.'/../app/Events',
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();