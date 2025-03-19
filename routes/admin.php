<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

//Work Group Modules
Route::group([
    'prefix'     => 'portal',
    'middleware' => ['g2fa'],
], function ($router) {

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
