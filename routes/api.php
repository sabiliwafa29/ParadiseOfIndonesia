<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\PaymentController;

// ✅ 1. AUTHENTICATION (tanpa middleware Sanctum)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ 2. API YANG BUTUH TOKEN LOGIN (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Profile user login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Booking-related endpoints
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);

    // Midtrans payment
    Route::get('/payments/{booking}/token', [PaymentController::class, 'getSnapToken']);
});

// ✅ 3. MIDTRANS CALLBACK (tanpa middleware, karena ini dari server Midtrans)
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification']);

// ✅ 4. LOCATION SEARCH (public, untuk autocomplete)
Route::get('/locations/search/{type}', [App\Http\Controllers\Api\LocationController::class, 'search']);
Route::post('/locations/create-or-get', [App\Http\Controllers\Api\LocationController::class, 'createOrGet']);
