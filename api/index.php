<?php

// Load the Laravel autoload file
require __DIR__.'/../vendor/autoload.php';

// Set up the Laravel application
$app = require_once __DIR__.'/../bootstrap/app.php';

// Set up the routing
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Handle the request
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Send the response
$response->send();

// Terminate the request
$kernel->terminate($request, $response);
