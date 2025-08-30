<?php

use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\TSController;
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
    'middleware' => ['api'],
    'prefix'     => 'v1',

], function ($router) {
    Route::get('/destinations', [FrontEndController::class, 'apiBasedDestinations']);

    Route::get('/tsAcctBal', [TSController::class, 'tsAcctBal']);
});
