<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Filters\V1\CustomerFilter;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Instantiate the CustomerFilter class to handle query parameter filtering
        $filter = new CustomerFilter();

        // Use the transform method to convert the request's query parameters
        // into an array of conditions that can be used in the database query.
        // Example: If the URL is ?name[eq]=John, the result might be: [['name', '=', 'John']]
        $queryItems = $filter->transform($request); // [['column', 'operator', 'value']]

        // Check if there are any filter conditions (query parameters) provided
        if (count($queryItems) == 0) {
            // If no query filters are provided, return all customers paginated.
            // No where() conditions are applied here, it simply returns all customers paginated.
            return new CustomerCollection(Customer::paginate());
        } else {
            // If filters exist, apply them to the Customer query using the where() method
            // Example: If $queryItems contains [['name', '=', 'John']], it will fetch
            // customers where the name is 'John' and paginate the results.
            $customers = Customer::where($queryItems)->paginate();

            // Return the paginated result with the original query parameters appended to the pagination links.
            // This ensures that when navigating between pages, the filters (e.g., ?name[eq]=John) are retained in the URL.
            return new CustomerCollection($customers->appends($request->query()));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
