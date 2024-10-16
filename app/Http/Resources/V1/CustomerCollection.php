<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * This method takes the entire customer collection (usually multiple customer records)
     * and transforms it into an array that can be returned in a JSON format for the API response.
     * 
     * The `parent::toArray($request)` calls the parent method from `ResourceCollection`, 
     * which automatically formats the collection based on individual resource transformations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Use the parent method to return the collection as an array.
        return parent::toArray($request);
    }
}
