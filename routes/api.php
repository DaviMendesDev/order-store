<?php

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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

//$data = [
//    [
//        "article_code" => "11111",
//        "article_name" => "test 1",
//        "unit_price" => "99.00",
//        "quantity" => "8",
//    ],
//    [
//        "article_code" => "22222",
//        "article_name" => "test 2",
//        "unit_price" => "99.00",
//        "quantity" => "9",
//    ],
//    [
//        "article_code" => "33333",
//        "article_name" => "test 3",
//        "unit_price" => "99.00",
//        "quantity" => "5",
//        "another_field" => [
//            [
//                "id" => "1"
//            ],
//            [
//                "id" => "5"
//            ],
//        ]
//    ],
//    new \App\Models\OrderProduct([
//        "article_code" => "44444",
//        "article_name" => "test 4",
//        "unit_price" => "99.00",
//        "quantity" => "14",
//    ]),
//    new \App\Models\OrderProduct([
//        "article_code" => "44444",
//        "article_name" => "test 4",
//        "unit_price" => "99.00",
//        "quantity" => "14",
//    ])
//];

//$data = new \App\Models\OrderProduct([
//    "article_code" => "44444",
//    "article_name" => "test 4",
//    "unit_price" => "99.00",
//    "quantity" => "14",
//]);
//
//Route::get('test', function () use ($data) {
//    $newData = \App\Utils\Aggregator::loadMethodValue(
//        'totalAmountWithoutDiscount',
//        'totalAmountWithoutDiscount',
//        $data,
//        'totalAmountWithoutDiscount'
//    );
//
//    $newData = \App\Utils\Aggregator::loadMethodValue(
//        'totalAmountWithoutDiscount',
//        'totalAmountWithoutDiscount',
//        $newData,
//        'totalAmountWithDiscount'
//    );
//    $newData = \App\Utils\Aggregator::rename([
//        'totalAmountWithoutDiscount' => 'total_amount',
//        'totalAmountWithDiscount' => 'total_amount_with_discount',
//    ], $newData);
//
//    return $newData;
//});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('orders')->name('orders.')->group(function () {
    Route::post('/store', [\App\Http\Controllers\Api\OrdersController::class, 'store'])->name('store');
    Route::get('/', [\App\Http\Controllers\Api\OrdersController::class, 'list'])->name('list');
});

Route::post('first-endpoint', [\App\Http\Controllers\EndpointController::class, 'firstEndpoint'])->name('first-endpoint');
Route::post('second-endpoint', [\App\Http\Controllers\EndpointController::class, 'secondEndpoint'])->name('second-endpoint');
Route::post('third-endpoint', [\App\Http\Controllers\EndpointController::class, 'thirdEndpoint'])->name('third-endpoint');

