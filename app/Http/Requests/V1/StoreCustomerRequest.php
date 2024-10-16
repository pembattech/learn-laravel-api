<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
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
        // Defining validation rules for each request field
        return [
            'name' => ['required'],                        // 'name' field is required
            'type' => [
                'required',                         // 'type' field is required and must match one of the allowed values
                Rule::in(['I', 'B', 'i', 'b'])
            ],           // Must be one of 'I', 'B', 'i', or 'b' (Individual or Business)
            'email' => ['required', 'email'],              // 'email' must be a valid email format and required
            'address' => ['required'],                     // 'address' field is required
            'city' => ['required'],                        // 'city' field is required
            'state' => ['required'],                       // 'state' field is required
            'postalCode' => ['required'],                  // 'postalCode' field is required
        ];
    }

    /**
     * Prepare the data for validation.
     * This method allows you to modify or format the incoming request data before applying validation rules.
     */
    protected function prepareForValidation()
    {
        // Rename 'postalCode' field to 'postal_code' before validation
        // This ensures that the database column name ('postal_code') is matched correctly
        $this->merge([
            'postal_code' => $this->postalCode
        ]);
    }
}

/*

Key Features Explained:
Authorization:
    The authorize() method returns true, which means any authenticated user can make the request. You can modify this method to include more complex authorization logic based on the user's role or permissions.

Validation Rules:
    The rules() method defines the validation rules for the incoming request. It ensures that:
        name, type, email, address, city, state, and postalCode are required fields.
        The type must be either 'I' or 'B' (case insensitive) using Rule::in().
        The email field must be a valid email format.

Field Mapping (Preparation for Validation):
    The prepareForValidation() method renames the postalCode input field to postal_code. This is necessary because the validation uses postalCode (in camelCase) as the request parameter, but in the database, the column is likely stored as postal_code (in snake_case). This method ensures consistency between request parameters and database fields.

*/
