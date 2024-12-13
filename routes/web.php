<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('welcome');
});
// routes/web.php
Route::post('/create-checkout-session', [CheckoutController::class, 'createCheckoutSession']);
