<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Reservation\ReservationController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Service\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ServiceController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('reservations')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/create/{serviceId}', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/', [ReservationController::class, 'store'])->name('reservations.store');
        Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });


});

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('services')->group(function () {
        Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/{id}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', \App\Livewire\AdminDashboard::class)->name('admin.dashboard');
        Route::get('/reservations/{id}/edit', [AdminReservationController::class, 'edit'])->name('admin.reservations.edit');
        Route::put('/reservations/{id}', [AdminReservationController::class, 'update'])->name('admin.reservations.update');
        Route::delete('/reservations/{id}', [AdminReservationController::class, 'destroy'])->name('admin.reservations.destroy');
    });

});
