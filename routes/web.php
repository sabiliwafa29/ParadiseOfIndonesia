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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('destinations', DestinationController::class);
Route::resource('tours', TourController::class);
Route::resource('tour-activities', TourActivityController::class);
Route::resource('gallery', GalleryController::class);
Route::resource('tour-packages', TourPackageController::class);
Route::resource('tour-sessions', TourSessionController::class);
Route::resource('travel-services', TravelServiceController::class);
Route::get('/search', [SearchController::class, 'index'])->name('search');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('my-bookings');
    Route::post('/bookings/{tour}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    // Admin: Tour management (protected by is_admin middleware)
    Route::prefix('admin')->name('admin.')->middleware('is_admin')->group(function () {
        Route::resource('tours', App\Http\Controllers\Admin\TourController::class);
    });
});

// Google Authentication Routes
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'callback']);

require __DIR__.'/auth.php';
