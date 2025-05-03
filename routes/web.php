<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
})->name("welcome");

Auth::routes();

Route::get('/home', [HomeController::class, 'dashboard'])->name('home');

Route::group([
    'prefix' => 'portal/superadmin',
], function ($router) {

    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

    Route::get('/change-password', [SuperAdminController::class, 'changePassword'])->name('superadmin.changePassword');

    Route::post('/update-password', [SuperAdminController::class, 'updatePassword'])->name('superadmin.updatePassword');

    Route::get('/platform-features', [AdminController::class, 'platformFeatures'])->name('super.platformFeatures');

    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('super.usermgt');

    Route::post('/storeUserPayrolRights', [AdminController::class, 'storeUserPayrolRights'])->name('super.storeUserPayrolRights');

    Route::post('/store-user', [AdminController::class, 'storeUser'])->name('super.storeUser');

    Route::post('/update-user', [AdminController::class, 'updateUser'])->name('super.updateUser');

    Route::get('/suspend-user', [AdminController::class, 'suspendUser'])->name('super.suspendUser');

    Route::get('/activate-user', [AdminController::class, 'activateUser'])->name('super.activateUser');

    Route::get('/user-roles', [AdminController::class, 'userRoles'])->name('super.userRoles');

    Route::post('/store-user-role', [AdminController::class, 'storeUserRole'])->name('super.storeUserRole');

    Route::post('/update-user-role', [AdminController::class, 'updateUserRole'])->name('super.updateUserRole');

    Route::get('/user-permissions/{id}', [AdminController::class, 'managePermissions'])->name('super.managePermissions');

    Route::get('/grant-feature-permission/{role}/{feature}', [AdminController::class, 'grantFeaturePermission'])->name('super.grantFeaturePermission');

    Route::get('/revoke-feature-permission/{role}/{feature}', [AdminController::class, 'revokeFeaturePermission'])->name('super.revokeFeaturePermission');

    Route::get('/grant-create-permission/{role}/{feature}', [AdminController::class, 'grantCreatePermission'])->name('super.grantCreatePermission');

    Route::get('/revoke-create-permission/{role}/{feature}', [AdminController::class, 'revokeCreatePermission'])->name('super.revokeCreatePermission');

    Route::get('/grant-edit-permission/{role}/{feature}', [AdminController::class, 'grantEditPermission'])->name('super.grantEditPermission');

    Route::get('/revoke-edit-permission/{role}/{feature}', [AdminController::class, 'revokeEditPermission'])->name('super.revokeEditPermission');

    Route::get('/grant-delete-permission/{role}/{feature}', [AdminController::class, 'grantDeletePermission'])->name('super.grantDeletePermission');

    Route::get('/revoke-delete-permission/{role}/{feature}', [AdminController::class, 'revokeDeletePermission'])->name('super.revokeDeletePermission');

    Route::get('/clear-cache', [AdminController::class, 'clearCache'])->name('super.clearCache');

});

require __DIR__ . '/admin.php';
require __DIR__ . '/passenger.php';
