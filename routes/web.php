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

    Route::get('/user-management', [SuperAdminController::class, 'userManagement'])->name('superadmin.userManagement');

    Route::post('/store-user', [SuperAdminController::class, 'storeUser'])->name('superadmin.storeUser');

    Route::post('/update-user', [SuperAdminController::class, 'updateUser'])->name('superadmin.updateUser');

    Route::get('/suspend-user/{id}', [SuperAdminController::class, 'suspendUser'])->name('superadmin.suspendUser');

    Route::get('/activate-user/{id}', [SuperAdminController::class, 'activateUser'])->name('superadmin.activateUser');

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

    Route::post('/store-terminal', [SuperAdminController::class, 'storeTerminal'])->name('superadmin.storeTerminal');

    Route::post('/update-terminal', [SuperAdminController::class, 'updateTerminal'])->name('superadmin.updateTerminal');

    Route::get('/activate-terminal/{id}', [SuperAdminController::class, 'activateTerminal'])->name('superadmin.activateTerminal');

    Route::get('/deactivate-terminal/{id}', [SuperAdminController::class, 'deactivateTerminal'])->name('superadmin.deactivateTerminal');

    Route::get('/clear-cache', [SuperAdminController::class, 'clearCache'])->name('superadmin.clearCache');

    Route::get('/fleet-management', [SuperAdminController::class, 'fleetManagement'])->name('superadmin.fleetManagement');

    Route::post('/storeVehicleDetails', [SuperAdminController::class, 'storeVehicleDetails'])->name('superadmin.storeVehicleDetails');

    Route::post('/updateVehicleDetails', [SuperAdminController::class, 'updateVehicleDetails'])->name('superadmin.updateVehicleDetails');

    Route::get('/vehicle/sold/{id}', [SuperAdminController::class, 'vehicleSold'])->name('superadmin.vehicleSold');

    Route::get('/vehicle/activate/{id}', [SuperAdminController::class, 'activateVehicle'])->name('superadmin.activateVehicle');

    Route::get('/vehicle/decommissioned/{id}', [SuperAdminController::class, 'vehicleDecommissioned'])->name('superadmin.vehicleDecommissioned');

    Route::get('/vehicle/maintenance/{id}', [SuperAdminController::class, 'underMaintenance'])->name('superadmin.underMaintenance');

    Route::get('/route-management', [SuperAdminController::class, 'routeManagement'])->name('superadmin.routeManagement');

    Route::post('/storeRoute', [SuperAdminController::class, 'storeRoute'])->name('superadmin.storeRoute');

    Route::post('/updateRoute', [SuperAdminController::class, 'updateRoute'])->name('superadmin.updateRoute');

    Route::get('/suspendRoute/{id}', [SuperAdminController::class, 'suspendRoute'])->name('superadmin.suspendRoute');

    Route::get('/activateRoute/{id}', [SuperAdminController::class, 'activateRoute'])->name('superadmin.activateRoute');

    Route::get('/travel-schedule', [SuperAdminController::class, 'travelSchedule'])->name('superadmin.travelSchedule');

    Route::post('/searchTravelSchedule', [SuperAdminController::class, 'searchTravelSchedule'])->name('superadmin.searchTravelSchedule');

    Route::get('/auth', [SuperAdminController::class, 'authenticationReport'])->name('superadmin.userAuths');

    Route::post('/searchUserAuths', [SuperAdminController::class, 'searchUserAuths'])->name('superadmin.searchUserAuths');

    Route::get('/userauths/{station?}/{et?}/{sd?}/{ed?}', [SuperAdminController::class, 'fetchUserAuths'])->name('superadmin.fetchUserAuths');

    Route::get('/audit', [SuperAdminController::class, 'auditTrailReport'])->name('superadmin.auditTrailReport');

    Route::post('/searchAuditTrails', [SuperAdminController::class, 'searchAuditTrails'])->name('superadmin.searchAuditTrails');

    Route::get('/audittrails/{et?}/{sd?}/{ed?}', [SuperAdminController::class, 'fetchAuditTrails'])->name('superadmin.fetchAuditTrails');

    Route::get('/financial-report', [SuperAdminController::class, 'financialReport'])->name('superadmin.financialReport');

});

require __DIR__ . '/admin.php';
require __DIR__ . '/passenger.php';
