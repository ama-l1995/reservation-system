<?php

use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Reservation\ReservationController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('reservations', ReservationController::class);
});
