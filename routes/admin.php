<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

//Work Group Modules
Route::group([
    'prefix' => 'portal/admin',
], function ($router) {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
