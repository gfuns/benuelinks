<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;

//Work Group Modules
Route::group([
    'prefix' => 'portal/admin',
], function ($router) {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/change-password', [AdminController::class, 'changePassword'])->name('admin.changePassword');

    Route::post('/update-password', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.userManagement');

    Route::post('/store-user', [AdminController::class, 'storeUser'])->name('admin.storeUser');

    Route::post('/update-user', [AdminController::class, 'updateUser'])->name('admin.updateUser');

    Route::get('/suspend-user/{id}', [AdminController::class, 'suspendUser'])->name('admin.suspendUser');

    Route::get('/activate-user/{id}', [AdminController::class, 'activateUser'])->name('admin.activateUser');

    Route::get('/travel-routes', [AdminController::class, 'travelRoutes'])->name('admin.travelRoutes');

    Route::post('/searchTravelRoutes', [AdminController::class, 'searchTravelRoutes'])->name('admin.searchTravelRoutes');

    Route::get('/filterTravelRoutes/{depa?}/{dest?}', [AdminController::class, 'filterTravelRoutes'])->name('admin.filterTravelRoutes');

    Route::get('/auth', [AdminController::class, 'authenticationReport'])->name('admin.userAuths');

    Route::post('/searchUserAuths', [AdminController::class, 'searchUserAuths'])->name('admin.searchUserAuths');

    Route::get('/userauths/{et?}/{sd?}/{ed?}', [AdminController::class, 'fetchUserAuths'])->name('admin.fetchUserAuths');

    Route::get('/audit', [AdminController::class, 'auditTrailReport'])->name('admin.auditTrailReport');

    Route::post('/searchAuditTrails', [AdminController::class, 'searchAuditTrails'])->name('admin.searchAuditTrails');

    Route::get('/audittrails/{et?}/{sd?}/{ed?}', [AdminController::class, 'fetchAuditTrails'])->name('admin.fetchAuditTrails');

    Route::get('/transactions-report', [AdminController::class, 'financialReport'])->name('admin.financialReport');

    Route::post('/filterTransactions', [AdminController::class, 'filterTransactions'])->name('admin.filterTransactions');

    Route::get('/transactions-report/{sd?}/{ed?}', [AdminController::class, 'processTransactionFilter'])->name('admin.processTransactionFilter');

    Route::get('/travel-schedule', [AdminController::class, 'travelSchedule'])->name('admin.travelSchedule');

    Route::post('/searchTravelSchedule', [AdminController::class, 'searchTravelSchedule'])->name('admin.searchTravelSchedule');

    Route::get('/filterTravelSchedule/{depa?}/{dest?}/{date?}', [AdminController::class, 'filterTravelSchedule'])->name('admin.filterTravelSchedule');

    Route::post('/storeTravelSchedule', [AdminController::class, 'storeTravelSchedule'])->name('admin.storeTravelSchedule');

    Route::post('/adjustDepartureTime', [AdminController::class, 'adjustDepartureTime'])->name('admin.adjustDepartureTime');

    Route::post('/updateTripStatus', [AdminController::class, 'updateTripStatus'])->name('admin.updateTripStatus');

    Route::post('/assignVehicle', [AdminController::class, 'assignVehicle'])->name('admin.assignVehicle');

    Route::get('/suspendTrip/{id}', [AdminController::class, 'suspendTrip'])->name('admin.suspendTrip');

    Route::get('/book-passengers', [AdminController::class, 'bookPassengers'])->name('admin.bookPassengers');

    Route::post('/processBooking', [AdminController::class, 'processBooking'])->name('admin.processBooking');

    Route::get('/pay-with-xtrapay/{id}', [AdminController::class, 'payWithXtrapay'])->name('admin.payWithXtrapay');

    Route::get('/booking-payment-details/{reference}', [AdminController::class, 'bookingPaymentDetails'])->name('admin.bookingPaymentDetails');

    Route::get('/searchBooking', [AdminController::class, 'searchBooking'])->name('admin.searchBooking');

    Route::post('/filterBookings', [AdminController::class, 'filterBookings'])->name('admin.filterBookings');

    Route::get('/processBookingFiltering/{schedule?}/{bkstatus?}/{date?}', [AdminController::class, 'processBookingFiltering'])->name('admin.processBookingFiltering');

    Route::get('/validate-ticket/{id}', [AdminController::class, 'validateTicket'])->name('admin.validateTicket');

    Route::get('/print-ticket/{id}', [AdminController::class, 'printBookingTicket'])->name('admin.printBookingTicket');

    Route::get('/board-passengers', [AdminController::class, 'boardPassengers'])->name('admin.boardPassengers');

    Route::get('/boarding/view-passengers/{id}', [AdminController::class, 'viewPassengers'])->name('admin.viewPassengers');

    Route::post('/processPassengerBoarding', [AdminController::class, 'processPassengerBoarding'])->name('admin.processPassengerBoarding');

    Route::get('/print-manifest/{id}', [AdminController::class, 'printPassengerManifest'])->name('admin.printPassengerManifest');

});

Route::get('/ajax/get-schedules/{terminal}/{date}', [AjaxController::class, 'getSchedules'])->name('ajax.getSchedules');
Route::get('/ajax/get-times/{terminal}/{destination}/{date}', [AjaxController::class, 'getDepatureTimes'])->name('ajax.getDepatureTimes');
Route::get('/ajax/get-seats/{terminal}/{destination}/{date}/{time}', [AjaxController::class, 'getAvailableSeats'])->name('ajax.availableSeats');
