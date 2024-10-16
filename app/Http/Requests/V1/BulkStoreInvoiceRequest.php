<?php
namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        // Always authorize the request. This can be modified if authorization logic is needed.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Defining validation rules for each field in the incoming request
        return [
            '*.customerId' => ['required', 'integer'],                  // Each object must have a required 'customerId' field as an integer
            '*.amount' => ['required', 'numeric'],                      // Each object must have a required 'amount' field as numeric
            '*.status' => ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])], // Each object must have a required 'status' field with specific valid values (case insensitive)
            '*.billedDate' => ['required'],                              // Each object must have a required 'billedDate' field
            '*.paidDate' => ['date_format:Y-m-d H:i:s', 'nullable'],    // Each object may have a 'paidDate' field that must be in a specific date format or can be null
        ];
    }

    /**
     * Prepare the data for validation.
     * This method allows you to modify or format the incoming request data before applying validation rules.
     */
    protected function prepareForValidation() {
        $data = []; // Initialize an empty array to hold transformed data

        // Loop through each item in the incoming request
        foreach ($this->toArray() as $obj) {
            // Map the incoming keys to the desired database column names
            $obj['customer_id'] = $obj['customerId'] ?? null; // Use 'customer_id' for the database field
            $obj['billed_date'] = $obj['billedDate'] ?? null; // Use 'billed_date' for the database field
            $obj['paid_date'] = $obj['paidDate'] ?? null;     // Correct typo in original code (from 'paid_dated' to 'paid_date')

            // Add the transformed object to the data array
            $data[] = $obj;
        }

        // Merge the transformed data back into the request
        $this->merge($data);
    }
}


/*

Key Features Explained:
Authorization:
    The authorize() method returns true, allowing any authenticated user to make this request. You can modify this method to implement specific authorization logic if necessary.

Validation Rules:
    The rules() method defines the validation rules for each field within the request. The rules specify that:
        ** Each item in the bulk request must have a customerId (required and must be an integer).
        ** Each item must also have an amount (required and must be numeric).
        ** The status must be one of the specified values ('B', 'P', 'V', case insensitive).
        ** The billedDate is required for each invoice.
        ** The paidDate must follow a specific date format (Y-m-d H:i:s) but can be null.

Data Preparation:

    The prepareForValidation() method transforms the incoming request data to match the desired format before validation rules are applied.
    It creates a new array $data to hold the transformed data. Inside the loop, it maps the incoming keys (customerId, billedDate, and paidDate) to their respective database column names (customer_id, billed_date, and paid_date).
    Note that there was a typo in the original code where paid_dated was used instead of paid_date. This has been corrected.
    Finally, the transformed data is merged back into the request, making it available for further processing.

*/