<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PlaneController;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\ReservationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('planes', PlaneController::class);
Route::apiResource('flights', FlightController::class);
Route::apiResource('reservations', ReservationController::class);
Route::apiResource('users', UserController::class);