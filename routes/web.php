<?php

use App\Http\Controllers\ReservationWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('reservations.index');
});

Route::resource('reservations', ReservationWebController::class);
Route::patch('reservations/{reservation}/change-state', [ReservationWebController::class, 'changeState'])
    ->name('reservations.change-state');
