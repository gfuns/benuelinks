<?php

use App\Http\Controllers\API\TransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['api', 'validatekey'],
    'prefix'     => 'v1',
], function ($router) {
    Route::post('/transfer/single', [TransferController::class, 'processSingleTransfer']);

    Route::post('/transfer/bulk', [TransferController::class, 'processBulkTransfer']);
});
