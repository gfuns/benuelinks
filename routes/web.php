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

    Route::get('/platform-features', [SuperAdminController::class, 'platformFeatures'])->name('superadmin.platformFeatures');

    Route::get('/user-management', [SuperAdminController::class, 'userManagement'])->name('superadmin.usermgt');

    Route::post('/store-user', [SuperAdminController::class, 'storeUser'])->name('superadmin.storeUser');

    Route::post('/update-user', [SuperAdminController::class, 'updateUser'])->name('superadmin.updateUser');

    Route::get('/suspend-user', [SuperAdminController::class, 'suspendUser'])->name('superadmin.suspendUser');

    Route::get('/activate-user', [SuperAdminController::class, 'activateUser'])->name('superadmin.activateUser');

    Route::get('/user-roles', [SuperAdminController::class, 'manageRoles'])->name('superadmin.manageRoles');

    Route::post('/store-user-role', [SuperAdminController::class, 'storeUserRole'])->name('superadmin.storeUserRole');

    Route::post('/update-user-role', [SuperAdminController::class, 'updateUserRole'])->name('superadmin.updateUserRole');

    Route::get('/user-permissions/{id}', [SuperAdminController::class, 'managePermissions'])->name('superadmin.managePermissions');

    Route::get('/grant-feature-permission/{role}/{feature}', [SuperAdminController::class, 'grantFeaturePermission'])->name('superadmin.grantFeaturePermission');

    Route::get('/revoke-feature-permission/{role}/{feature}', [SuperAdminController::class, 'revokeFeaturePermission'])->name('superadmin.revokeFeaturePermission');

    Route::get('/grant-create-permission/{role}/{feature}', [SuperAdminController::class, 'grantCreatePermission'])->name('superadmin.grantCreatePermission');

    Route::get('/revoke-create-permission/{role}/{feature}', [SuperAdminController::class, 'revokeCreatePermission'])->name('superadmin.revokeCreatePermission');

    Route::get('/grant-edit-permission/{role}/{feature}', [SuperAdminController::class, 'grantEditPermission'])->name('superadmin.grantEditPermission');

    Route::get('/revoke-edit-permission/{role}/{feature}', [SuperAdminController::class, 'revokeEditPermission'])->name('superadmin.revokeEditPermission');

    Route::get('/grant-delete-permission/{role}/{feature}', [SuperAdminController::class, 'grantDeletePermission'])->name('superadmin.grantDeletePermission');

    Route::get('/revoke-delete-permission/{role}/{feature}', [SuperAdminController::class, 'revokeDeletePermission'])->name('superadmin.revokeDeletePermission');

    Route::get('/terminal-management', [SuperAdminController::class, 'terminalManagement'])->name('superadmin.terminalManagement');

    Route::get('/clear-cache', [SuperAdminController::class, 'clearCache'])->name('superadmin.clearCache');

});

require __DIR__ . '/admin.php';
require __DIR__ . '/passenger.php';
