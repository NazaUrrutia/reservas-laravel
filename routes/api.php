<?php

use App\Http\Controllers\Api\ReservationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('reservations', ReservationController::class)->names([
    'index' => 'api.reservations.index',
    'store' => 'api.reservations.store',
    'show' => 'api.reservations.show',
    'update' => 'api.reservations.update',
    'destroy' => 'api.reservations.destroy',
]);
Route::patch('reservations/{reservation}/state', [ReservationController::class, 'changeState'])
    ->name('api.reservations.changeState');