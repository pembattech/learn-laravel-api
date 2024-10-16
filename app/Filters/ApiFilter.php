<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    // Array defining the allowed query parameters and their corresponding operators
    protected $safeParms = [];

    // Optional array to map query parameters to specific database column names
    protected $columnMap = [];

    // Array that maps custom operator names to SQL operators
    protected $operatorMap = [];

    /**
     * Transforms request query parameters into an array suitable for Eloquent queries.
     * 
     * @param \Illuminate\Http\Request $request
     * @return array Eloquent query conditions
     */
    public function transform(Request $request)
    {
        // Initialize an empty array to hold the query conditions
        $eloQuery = [];

        // Loop through the safe parameters defined in the class
        foreach ($this->safeParms as $parm => $operators){
            // Get the query parameter from the request
            $query = $request->query($parm);

            // If the query parameter is not present in the request, skip to the next one
            if(!isset($query)) {
                continue;
            }

            // Map the parameter to its corresponding column in the database, if defined
            $column = $this->columnMap[$parm] ?? $parm;

            // Loop through the allowed operators for the current parameter
            foreach($operators as $operator) {
                // If the query contains the operator, add the condition to the Eloquent query array
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        // Return the array of conditions to be used in an Eloquent query
        return $eloQuery;
    }
}

/*
transform() Method:
    - This method processes the incoming Request and checks if the safe parameters are present.
    - If present, it retrieves the associated query parameter, checks for the corresponding operator, and appends the condition (column, operator, value) to an array.
    - The resulting array can then be used in an Eloquent where clause to filter results based on the user’s request.

*/