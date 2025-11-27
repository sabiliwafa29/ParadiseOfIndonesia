<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingStatusController;

// ✅ 1. AUTHENTICATION (with rate limiting and security headers)
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ✅ 2. API YANG BUTUH TOKEN LOGIN (auth:sanctum with rate limiting)
Route::middleware(['auth:sanctum', 'throttle:100,60'])->group(function () {
    // Profile user login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Booking-related endpoints (20 per minute, 100 per hour)
    Route::post('/bookings', [BookingController::class, 'store'])->middleware('throttle:20,1;100,60');
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);

    // Midtrans payment
    Route::get('/payments/{booking}/token', [PaymentController::class, 'getSnapToken']);
});

// ✅ 3. MIDTRANS CALLBACK (tanpa middleware, karena ini dari server Midtrans)
Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification']);

// ✅ 3B. FRONTEND PAYMENT CALLBACK (untuk update status dari browser setelah payment)
Route::post('/bookings/{booking}/payment-status', [BookingStatusController::class, 'updatePaymentStatus']);

// ✅ 4. LOCATION SEARCH (public, for autocomplete - 30 per minute)
Route::get('/locations/search/{type}', [App\Http\Controllers\Api\LocationController::class, 'search'])->middleware('throttle:30,60');
Route::post('/locations/create-or-get', [App\Http\Controllers\Api\LocationController::class, 'createOrGet'])->middleware('throttle:30,60');

// ✅ 5. DISTANCE CALCULATION (public, for OSRM - 20 per minute)
Route::get('/distance/calculate', [App\Http\Controllers\Api\DistanceController::class, 'calculate'])
    ->middleware('throttle:20,60');

// ✅ 6. HEALTH CHECK ENDPOINTS (public, for monitoring - 60 per minute)
Route::middleware('throttle:60,60')->group(function () {
    Route::get('/health', [App\Http\Controllers\Api\HealthController::class, 'check']);
    Route::get('/health/detailed', [App\Http\Controllers\Api\HealthController::class, 'detailed']);
    Route::get('/health/osrm', [App\Http\Controllers\Api\HealthController::class, 'osrm']);
});

// PayPal endpoints (used by client-side PayPal Buttons)
use App\Http\Controllers\PayPalController;

// PayPal endpoints need session/web middleware for guest bookings (session-based access)
Route::middleware('web')->group(function () {
    Route::post('/paypal/{booking}/create-order', [PayPalController::class, 'createOrder']);
    Route::post('/paypal/{booking}/capture-order', [PayPalController::class, 'captureOrder']);
});
