<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/shopify-products', [ProductController::class, 'getShopifyProducts']);
Route::get('/featured-products', [ProductController::class, 'getFeaturedProducts']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::get('/products/{id}', [ProductController::class, 'getShopifyProductDetails']);
Route::post('/checkout', [CheckoutController::class, 'createCheckout']);

Route::options('{any}', function () {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', 'https://shoes1-omega.vercel.app')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
        ->header('Access-Control-Allow-Credentials', 'true');
})->where('any', '.*');

