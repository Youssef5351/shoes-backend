<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/shopify-products', [ProductController::class, 'getShopifyProducts']);
Route::get('/featured-products', [ProductController::class, 'getFeaturedProducts']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::get('/products/{id}', [ProductController::class, 'getShopifyProductDetails']);
Route::post('/checkout', [CheckoutController::class, 'createCheckout']);
