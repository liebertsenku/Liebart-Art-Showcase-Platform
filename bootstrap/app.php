<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // <-- Pastikan ini ada

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // === TAMBAHKAN ALIAS ANDA DI SINI ===
        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

            'role' => \App\Http\Middleware\CheckRole::class,
            'curator.approved' => \App\Http\Middleware\CheckCuratorStatus::class,
            'curator.pending' => \App\Http\Middleware\CheckPendingCurator::class,
        ]);
        // ===================================

        // Mungkin ada middleware lain yang sudah ada di sini
        // $middleware->validateCsrfTokens(except: [ ... ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();