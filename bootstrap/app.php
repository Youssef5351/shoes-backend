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
    $middleware->append(function ($request, $next) {
        $response = $next($request);
        
        $response->headers->set('Access-Control-Allow-Origin', 'https://shoes1-omega.vercel.app');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        
        return $response;
    });
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
