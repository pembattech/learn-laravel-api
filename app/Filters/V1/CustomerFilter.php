<?php

// 
// namespace App\Filters\V1;
// 
// use Illuminate\Http\Request;
// 
// class CustomerFilter extends ApiFilter
// {
// protected $safeParms = [
// 'name' => ['eq'],
// 'type' => ['eq'],
// 'email' => ['eq'],
// 'address' => ['eq'],
// 'city' => ['eq'],
// 'state' => ['eq'],
// 'postalCode' => ['eq', 'gt', 'lt']
// ];
// 
// protected $columnMap = [
// 'postalCode' => 'postal_code'
// ];
// 
// protected $operatorMap = [
// 'eq' => '=',
// 'lt' => '<',
// 'gt' => '>',
// 'lte' => '<=',
// 'gte' => '>='
// // also supports 'in' and 'like' operator by elo
// ];
// 
// public function transform(Request $request)
// {
// $eloQuery = [];
// 
// foreach ($this->safeParms as $parm => $operators){
// $query = $request->query($parm);
// 
// if(!isset($query)) {
// continue;
// }
// 
// $column = $this->columnMap[$parm] ?? $parm;
// 
// foreach($operators as $operator) {
// if (isset($query[$operator])) {
// $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
// }
// }
// }
// return $eloQuery;
// }
// }


namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class CustomerFilter extends ApiFilter
{
    // Define allowed query parameters for the customer filtering, 
    // along with their acceptable operators (e.g., 'eq', 'gt', 'lt')
    protected $safeParms = [
        'name' => ['eq'],        // Allow filtering by exact name
        'type' => ['eq'],        // Allow filtering by exact type (e.g., individual or business)
        'email' => ['eq'],       // Allow filtering by exact email
        'address' => ['eq'],     // Allow filtering by exact address
        'city' => ['eq'],        // Allow filtering by exact city
        'state' => ['eq'],       // Allow filtering by exact state
        'postalCode' => ['eq', 'gt', 'lt']  // Allow filtering by postal code, with exact, greater than, and less than operators
    ];

    // Define a column mapping for fields that need to be mapped to a different column name in the database
    // For example, 'postalCode' in the request maps to 'postal_code' in the database
    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    // Map operators used in the query (e.g., 'eq', 'lt') to their corresponding SQL operators (e.g., '=', '<')
    protected $operatorMap = [
        'eq' => '=',   // Exact match (equals)
        'lt' => '<',   // Less than
        'gt' => '>',   // Greater than
        'lte' => '<=', // Less than or equal to
        'gte' => '>='  // Greater than or equal to
        // Can also support 'in' and 'like' operators if needed
    ];
}


/*

Key Points:
    safeParms:
        Defines the query parameters the API will accept for filtering (like name, email, postalCode). Each parameter can have one or more operators (e.g., eq, gt, lt).

    columnMap:
        If the request uses a parameter name that doesn't directly match the column name in the database, this array maps it (e.g., postalCode maps to postal_code in the database).

    operatorMap:
        Converts user-friendly operators like eq (equals) into actual SQL operators like =. It also supports greater than (gt), less than (lt), etc.

By using this filter, you can allow clients to query customer records with various parameters and operators in a structured and secure way. The filter will take query parameters like postalCode[gt]=5000 and translate them into Eloquent queries that the database understands.

*/