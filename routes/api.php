<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {

    // filter_url:
    //      http://127.0.0.1:8000/api/v1/customers?state[eq]=California
    //      http://127.0.0.1:8000/api/v1/customers?type[eq]=B&city[eq]=Laurenceshire

    Route::apiResource('customers', CustomerController::class);
    //      http://127.0.0.1:8000/api/v1/invoices?status[ne]=P
    Route::apiResource('invoices', InvoiceController::class);
});
