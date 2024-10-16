<?php

namespace App\Http\Resources\V1;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postalCode' => $this->postal_code,
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices'))
        ];
    }
}

/*
Key Features:
    Transforming Customer Data:
        The toArray() method transforms the customer data into a clean array format, which is perfect for an API response. Each field, like id, name, type, email, etc., is extracted from the customer model.
        
    Conditional Relationships (whenLoaded()):
        The whenLoaded('invoices') method ensures that the customer's invoices are only included in the response if the invoices relationship has been pre-loaded (via eager loading). This prevents unnecessary queries and keeps the API efficient.
        
    Handling Nested Resources:
        If invoices are included, the InvoiceResource::collection() is used to transform each invoice associated with the customer, ensuring consistency in formatting both the customer and related invoices.
*/