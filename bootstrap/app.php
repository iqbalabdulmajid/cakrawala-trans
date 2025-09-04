<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
        ->withMiddleware(function (Middleware $middleware) {

        // --- TAMBAHKAN BLOK INI ---
        // Pengecualian untuk token CSRF.
        // URL yang ada di sini tidak akan diperiksa token CSRF-nya.
        $middleware->validateCsrfTokens(except: [
            'midtrans/notification', // <-- URL webhook Anda
        ]);
        // --- AKHIR BLOK TAMBAHAN ---


        // Ini adalah pendaftaran alias middleware admin yang sudah ada
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
