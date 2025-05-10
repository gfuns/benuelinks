<?php

use App\Http\Controllers\Admin\AdminController;
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

});
