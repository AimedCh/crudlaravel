<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'client' => \App\Http\Middleware\ClientMiddleware::class,
        ]);

        // Exempt public JSON endpoints from CSRF to allow frontend submissions without tokens
        $middleware->validateCsrfTokens(except: [
            'contacto/public',
            'alquileres/reserve/public',
            'backend/*', // Todas las rutas del backend para el frontend React
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
