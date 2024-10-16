<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\CustomerResource;   // Resource for transforming a single customer instance
use App\Http\Resources\V1\CustomerCollection; // Resource for transforming a collection of customers
use App\Models\Customer;                       // Customer model for interacting with the database
use App\Http\Controllers\Controller;            // Base controller class for Laravel controllers
use App\Filters\V1\CustomerFilter;             // Filter class for processing query parameters
use Illuminate\Http\Request;                    // Request class for handling HTTP requests
use App\Http\Requests\V1\StoreCustomerRequest; // Request class for validating customer creation
use App\Http\Requests\V1\UpdateCustomerRequest; // Request class for validating customer updates

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * This method retrieves a list of customers, optionally filtered
     * by query parameters and includes related invoices.
     */
    public function index(Request $request)
    {
        $filter = new CustomerFilter(); // Create a new instance of the CustomerFilter

        // Transform the incoming request into filterable query items
        $FilterItems = $filter->transform($request); // [['column', 'operator', 'value']]

        // Check if the request includes the 'includeInvoices' query parameter
        $includeInvoices = $request->query('includeInvoices');

        // Start building the customer query
        $customers = Customer::where($FilterItems);

        // If 'includeInvoices' is set, load the related invoices
        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        // Paginate the results and append the original query parameters for links
        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * This method is typically used for returning a form view in web applications.
     * In APIs, this might not be needed.
     */
    public function create()
    {
        // Not implemented, as API does not usually return views
    }

    /**
     * Store a newly created resource in storage.
     * 
     * This method validates and creates a new customer using the provided request data.
     */
    public function store(StoreCustomerRequest $request)
    {
        // Create a new customer and return it as a resource
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     * 
     * This method shows a single customer, optionally including their invoices.
     */
    public function show(Request $request, Customer $customer)
    {
        // Check if the request includes the 'includeInvoices' query parameter
        $includeInvoices = $request->query('includeInvoices');
        if ($includeInvoices) {
            // Load invoices and return the customer resource
            return new CustomerResource($customer->loadMissing('invoices'));
        }
        // Return the customer resource without invoices
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * This method is typically used for returning a form view in web applications.
     * In APIs, this might not be needed.
     */
    public function edit(Customer $customer)
    {
        // Not implemented, as API does not usually return views
    }

    /**
     * Update the specified resource in storage.
     * 
     * This method validates and updates an existing customer with the provided request data.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        // Update the customer using the validated request data
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     * 
     * This method deletes a specified customer.
     */
    public function destroy(Customer $customer)
    {
        // Not implemented, but should include logic to delete the customer
        // e.g., $customer->delete();
    }
}


/**
 * Key Features Explained:
 * Index Method:

    * The index() method retrieves a list of customers based on optional filtering criteria from the request.
    * It utilizes a CustomerFilter instance to transform the incoming request parameters into query conditions.
    * If the includeInvoices query parameter is set, it will also load the related invoices for each customer.

 * Store Method:
    * The store() method uses the StoreCustomerRequest class to validate the incoming request data before creating a new customer.
    * Upon successful creation, it returns a CustomerResource, which formats the customer data according to the API response structure.

 * Show Method:
    * The show() method displays a specific customer resource.
    * Similar to index(), it can include related invoices based on the includeInvoices query parameter.

 * Update Method:
    * The update() method uses the UpdateCustomerRequest to validate the incoming data for updating an existing customer.
    * It updates the customer instance using the validated data.

 * Destroy Method:
    * The destroy() method is defined but not implemented. This is where you would typically add the logic to delete a customer resource.

 * Use of Resources:
    * The controller utilizes CustomerResource and CustomerCollection to handle the transformation of customer models into JSON format, ensuring a consistent API response structure.

 * RESTful Structure:
    * The methods follow RESTful principles, where each HTTP method corresponds to a specific action (GET for retrieving, POST for creating, PUT/PATCH for updating, and DELETE for removing).

 */
