<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypecontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('product-types', ProductTypeController::class);

Route::get('product', [ProductController::class, 'index']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::post('register', [AuthController::class, 'register']);


Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::post('product', [ProductController::class, 'store']);
    Route::post('product-update/{id}', [ProductController::class, 'store']);
    
});

Route::resource('banner', BannerController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
