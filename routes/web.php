<?php

use App\Http\Controllers\CronController;
use App\Http\Controllers\HomeController;
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

Route::get('/cron/validateAccounts', [CronController::class, 'validateAccounts'])->name('validateAccounts');

Route::get('/cron/initiateBulkTransfer', [CronController::class, 'initiateBulkTransfer'])->name('initiateBulkTransfer');

Route::get('/home', [HomeController::class, 'dashboard'])->name('home');

Route::group([
    'prefix'     => 'portal',
    'middleware' => ['g2fa'],
], function ($router) {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/change-password', [HomeController::class, 'changePassword'])->name('changePassword');

    Route::post('/update-password', [HomeController::class, 'updatePassword'])->name('updatePassword');

    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

    Route::get('/single-transfer', [HomeController::class, 'singleTransfer'])->name('singleTransfer');

    Route::post('/processSingleTransfer', [HomeController::class, 'processSingleTransfer'])->name('processSingleTransfer');

    Route::get('/single-transactions', [HomeController::class, 'singleTransactionHistory'])->name('singleTransactionHistory');

    Route::get('/bulk-transfer', [HomeController::class, 'bulkTransfer'])->name('bulkTransfer');

    Route::post('/processBulkTransfer', [HomeController::class, 'processBulkTransfer'])->name('processBulkTransfer');

    Route::get('/bulkTransferUploadReport/{trackingCode}', [HomeController::class, 'bulkTransferUploadReport'])->name('bulkTransferUploadReport');

    Route::get('/bulk-transactions', [HomeController::class, 'bulkTransactionHistory'])->name('bulkTransactionHistory');

    Route::get('/bulk-transactions/beneficiaries/{id}', [HomeController::class, 'bulkTransferBeneficiaries'])->name('bulkTransferBeneficiaries');

    Route::get('/transaction-history', [HomeController::class, 'transactionHistory'])->name('transactionHistory');

    Route::post('/validate-account', [HomeController::class, 'validateBankAccount'])->name('business.validateAccount');

    Route::get('/exportBankCodes', [HomeController::class, 'exportBankCodes'])->name('exportBankCodes');

    Route::post('/resolveBulkTransferImportIssue', [HomeController::class, 'resolveBulkTransferImportIssue'])->name('resolveBulkTransferImportIssue');

    Route::get('/screenBulkTransferUpload/{trackingCode}', [HomeController::class, 'screenBulkTransferUpload'])->name('screenBulkTransferUpload');

    Route::get('/finalizeBulkTransferUpload/{trackingCode}', [HomeController::class, 'finalizeBulkTransferUpload'])->name('finalizeBulkTransferUpload');

});

require __DIR__ . '/admin.php';
