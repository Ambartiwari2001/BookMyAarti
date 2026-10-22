<?php

use App\Http\Controllers\AartiController;
use App\Http\Controllers\Admin\AartiController as AdminAartiController;
use App\Http\Controllers\Admin\AddOnController as AdminAddOnController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CheckInController as AdminCheckInController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GhatController as AdminGhatController;
use App\Http\Controllers\Admin\SlotController as AdminSlotController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GhatController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Devotee Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/aartis', [AartiController::class, 'index'])->name('aartis.index');
Route::get('/aartis/{slug}', [AartiController::class, 'show'])->name('aartis.show');

Route::get('/ghats', [GhatController::class, 'index'])->name('ghats.index');
Route::get('/ghats/{slug}', [GhatController::class, 'show'])->name('ghats.show');

// Booking Flow
Route::get('/book/{slot}', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/pass/{bookingNumber}', [BookingController::class, 'pass'])->name('booking.pass');
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegistration'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Control Panel Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Aartis Management
    Route::resource('aartis', AdminAartiController::class);

    // Ghats Management
    Route::resource('ghats', AdminGhatController::class);

    // Slots & Capacity Scheduler
    Route::post('slots/batch-generate', [AdminSlotController::class, 'batchGenerate'])->name('slots.batch');
    Route::resource('slots', AdminSlotController::class);

    // Bookings & Devotee Registers
    Route::get('bookings/print/register', [AdminBookingController::class, 'printRegister'])->name('bookings.print');
    Route::post('bookings/{booking}/attended', [AdminBookingController::class, 'markAttended'])->name('bookings.attended');
    Route::post('bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::resource('bookings', AdminBookingController::class)->only(['index', 'show']);

    // Gate Check-in & Scanner
    Route::get('check-in', [AdminCheckInController::class, 'index'])->name('check-in.index');
    Route::post('check-in/{booking}', [AdminCheckInController::class, 'confirm'])->name('check-in.confirm');

    // Offerings & Prasad Add-ons
    Route::resource('add-ons', AdminAddOnController::class);
});
