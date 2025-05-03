<?php

use App\Http\Controllers\Passenger\PassengerController;
use Illuminate\Support\Facades\Route;

//Work Group Modules
Route::group([
    'prefix' => 'portal/passenger',
], function ($router) {

    Route::get('/dashboard', [PassengerController::class, 'dashboard'])->name('passenger.dashboard');
});
