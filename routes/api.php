<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TestimonyController;

// GRUP PUBLIC
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// GRUP PROTECTED
Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']); 
});

// GRUP PROTECTED DATA 
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    Route::post('/checkout', [PaymentController::class, 'store']);

    Route::post('/menus', [MenuController::class, 'store']);
    Route::put('/menus/{id}', [MenuController::class, 'update']);

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']); 
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    Route::post('/contact/update-info', [ContactController::class, 'update']);
    Route::post('/contact/social-media', [ContactController::class, 'storeSocialMedia']);
    Route::delete('/contact/social-media/{id}', [ContactController::class, 'destroySocialMedia']);

    Route::post('/testimony', [TestimonyController::class, 'store']);
    Route::put('/testimony/{id}', [TestimonyController::class, 'update']);
    Route::delete('/testimony/{id}', [TestimonyController::class, 'destroy']);
});

// PUBLIC DATA MENU
Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{id}', [MenuController::class, 'show']);

// PUBLIC DATA KATEGORI
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// PUBLIC DATA KONTAK
Route::get('/contact', [ContactController::class, 'index']);

// PUBLIC DATA TESTIMONI
Route::get('/testimony', [TestimonyController::class, 'index']);
Route::get('/testimony/{id}', [TestimonyController::class, 'show']);

// Webhook Midtrans
Route::post('midtrans-callback', [MidtransCallbackController::class, 'callback']);