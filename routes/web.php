<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;

Route::get('/', function () {return view('welcome');})->name('welcome');
Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
