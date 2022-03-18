<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\OrdersController::class, 'list'])->name('list');
    Route::post('/store', [\App\Http\Controllers\Api\OrdersController::class, 'store'])->name('store');
    Route::put('{order}/update', [\App\Http\Controllers\Api\OrdersController::class, 'update'])->name('update');
});
