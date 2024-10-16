<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\CustomerController; // Importing the CustomerController
use App\Http\Controllers\Api\V1\InvoiceController;  // Importing the InvoiceController

// Route for retrieving the authenticated user
Route::get('/user', function (Request $request) {
    return $request->user(); // Returns the authenticated user information
})->middleware('auth:sanctum'); // Applying Sanctum authentication middleware

// Grouping routes under the 'v1' prefix and specifying the namespace and middleware
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {

    // Example filter URLs for customers
    // http://127.0.0.1:8000/api/v1/customers?state[eq]=California
    // http://127.0.0.1:8000/api/v1/customers?type[eq]=B&city[eq]=Laurenceshire

    // Defining a RESTful API resource for customers
    Route::apiResource('customers', CustomerController::class);

    // Example filter URL for invoices
    // http://127.0.0.1:8000/api/v1/invoices?status[ne]=P

    // Defining a RESTful API resource for invoices
    Route::apiResource('invoices', InvoiceController::class);

    // Route for bulk storing invoices, calling the bulkStore method on InvoiceController
    Route::post('invoices/bulk', ['uses' => 'InvoiceController@bulkStore']);
});


/*
Endpoints:

API V1: Customers
    GET /api/v1/customers - List customers (with filtering)
    GET /api/v1/customers?includeInvoices=true - List customers with invoices
    POST /api/v1/customers - Create customer
    GET /api/v1/customers/{customer} - Show customer
    GET /api/v1/customers/{customer}?includeInvoices=true - Show customer with invoices
    PUT/PATCH /api/v1/customers/{customer} - Update customer
    DELETE /api/v1/customers/{customer} - Delete customer

API V1: Invoices
    GET /api/v1/invoices - List invoices (with filtering)
    POST /api/v1/invoices - Create invoice
    POST /api/v1/invoices/bulk - Bulk create invoices
    GET /api/v1/invoices/{invoice} - Show invoice
    PUT/PATCH /api/v1/invoices/{invoice} - Update invoice
    DELETE /api/v1/invoices/{invoice} - Delete invoice

Setup
    GET /setup - Setup admin user

*/