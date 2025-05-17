<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Passenger\PassengerController;
use App\Http\Controllers\PaystackController;
use Illuminate\Support\Facades\Route;

//Work Group Modules
Route::group([
    'prefix'     => 'portal/passenger',
    'middleware' => ['emailverified'],
], function ($router) {

    Route::get('/dashboard', [PassengerController::class, 'dashboard'])->name('passenger.dashboard');

    Route::get('/account-settings', [PassengerController::class, 'accountSettings'])->name('passenger.accountSettings');

    Route::post('/updateProfile', [PassengerController::class, 'updateProfile'])->name('passenger.updateProfile');

    Route::post('/updatePassword', [PassengerController::class, 'updatePassword'])->name('passenger.updatePassword');

    Route::post('/walletPinSetup', [PassengerController::class, 'walletPinSetup'])->name('passenger.walletPinSetup');

    Route::post('/updateWalletPin', [PassengerController::class, 'updateWalletPin'])->name('passenger.updateWalletPin');

    Route::post('/initiateWalletTopup', [PaystackController::class, 'initiateWalletTopup'])->name('passenger.initiateWalletTopup');

    Route::get('/wallet', [PassengerController::class, 'wallet'])->name('passenger.wallet');

    Route::get('/booking-history', [PassengerController::class, 'bookingHistory'])->name('passenger.bookingHistory');

    Route::get('/referrals', [PassengerController::class, 'referrals'])->name('passenger.referrals');

    Route::get('/pricing', [PassengerController::class, 'pricing'])->name('passenger.pricing');

    Route::post('/searchSchedule', [PassengerController::class, 'searchSchedule'])->name('passenger.searchSchedule');

    Route::get('/trip/search/{dep?}/{des?}/{date?}', [PassengerController::class, 'availableBuses'])->name('passenger.availableBuses');

    Route::post('/seatSelection', [PassengerController::class, 'seatSelection'])->name('passenger.seatSelection');

    Route::get('/passenger-details/{id}', [PassengerController::class, 'passengerDetails'])->name('passenger.passengerDetails');

    Route::post('/updatePassengerDetails', [PassengerController::class, 'updatePassengerDetails'])->name('passenger.updatePassengerDetails');

    Route::get('/booking-preview/{id}', [PassengerController::class, 'bookingPreview'])->name('passenger.bookingPreview');

    Route::post('/bookingPayment', [PassengerController::class, 'bookingPayment'])->name('passenger.bookingPayment');

    Route::post('/payWithCard', [PaystackController::class, 'payWithCard'])->name('passenger.payWithCard');

    Route::get('/payWithWallet/{id}', [PassengerController::class, 'payWithWallet'])->name('passenger.payWithWallet');
});

Route::get('/paystack/callback', [PaystackController::class, 'handlePaystackCallback']);

Route::get('/ajax/get-bookedSeats/{scheduleid}', [AjaxController::class, 'getBookedSeats'])->name('ajax.bookedSeats');
