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
    ->withMiddleware(function (Middleware $middleware): void {
        // Leave empty for now - will be configured per environment
        // Production proxy settings should be in .env: TRUST_PROXIES=*
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
