<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TourActivityController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\TourSessionController;
use App\Http\Controllers\TravelServiceController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public view routes (bisa diakses tanpa login)
Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');

Route::get('/tour-activities', [TourActivityController::class, 'index'])->name('tour-activities.index');
Route::get('/tour-activities/{activity}', [TourActivityController::class, 'show'])->name('tour-activities.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('tour-packages.index');
Route::get('/tour-packages/{package}', [TourPackageController::class, 'show'])->name('tour-packages.show');

// Booking package (bisa tanpa login)
Route::get('/bookings/package/{package}', [BookingController::class, 'package'])->name('bookings.package');
Route::post('/bookings/package/{package}', [BookingController::class, 'storePackage'])->name('bookings.store-package');

Route::get('/tour-sessions', [TourSessionController::class, 'index'])->name('tour-sessions.index');
Route::get('/tour-sessions/{session}', [TourSessionController::class, 'show'])->name('tour-sessions.show');
Route::get('/bookings/session/{session}', [BookingController::class, 'createFromSession'])->name('bookings.session');

Route::get('/travel-services', [TravelServiceController::class, 'index'])->name('travel-services.index');
Route::get('/travel-services/{service}', [TravelServiceController::class, 'show'])->name('travel-services.show');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/travel-map', [App\Http\Controllers\TravelMapController::class, 'index'])->name('travel-map');

Route::post('/language/switch', [App\Http\Controllers\LanguageController::class, 'switch'])
    ->name('language.switch');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | USER ROUTES (Admin tidak bisa akses)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:user'])->group(function () {
        
        // Dashboard User
        Route::get('/dashboard', function () {
            return redirect()->route('home')
                ->with('login_success', true)
                ->with('user_name', auth()->user()->name);
        })->name('dashboard');
        
        // Profile Management
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        // Travel Services Booking (hanya user yang bisa booking)
        Route::prefix('travel-services')->name('travel-services.')->group(function () {
            Route::get('/{service}/booking', [TravelServiceController::class, 'booking'])->name('booking');
            Route::post('/{service}/confirm', [TravelServiceController::class, 'confirm'])->name('confirm');
            Route::post('/{service}/pay', [TravelServiceController::class, 'pay'])->name('pay');
            Route::get('/payment/success', [TravelServiceController::class, 'paymentSuccess'])->name('payment.success');
        });
        
        // My Bookings (khusus user login)
        Route::get('/my-bookings', [BookingController::class, 'index'])->name('my-bookings');
        Route::post('/bookings/{tour}', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    });
    
    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES (User tidak bisa akses)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Admin Dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Tour Management
        Route::resource('/tours', App\Http\Controllers\Admin\TourController::class);
        
        // Destination Management (jika ada controller admin)
        Route::resource('/destinations', App\Http\Controllers\Admin\DestinationController::class);
        
    // Travel Service Management
    Route::resource('travel-services', App\Http\Controllers\Admin\TravelServiceController::class);
        
    // Booking Management
    Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class);
        
    // User Management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        
    // Gallery Management
    Route::resource('gallery', App\Http\Controllers\Admin\GalleryController::class);
        
    // Tour Activity Management
    Route::resource('tour-activities', App\Http\Controllers\Admin\TourActivityController::class);
        
    // Tour Package Management
    Route::resource('tour-packages', App\Http\Controllers\Admin\TourPackageController::class);
        
    // Tour Session Management
    Route::resource('tour-sessions', App\Http\Controllers\Admin\TourSessionController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Google Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| Auth Routes (Login, Register, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';