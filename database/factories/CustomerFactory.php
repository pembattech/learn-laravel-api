<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Randomly select a type for the customer, either 'I' (Individual) or 'B' (Business)
        $type = $this->faker->randomElement(['I', 'B']);
        
        // If the type is 'I' (Individual), generate a person's name; 
        // Otherwise, generate a company name for type 'B' (Business)
        $name = $type === 'I' ? $this->faker->name() : $this->faker->company();

        // Return an array of data representing the Customer model's fields
        return [
            'name' =>  $name,  // Name of the individual or business
            'type' => $type,   // 'I' for individual, 'B' for business
            'email' => $this->faker->email(), // Generate a random email address
            'address' => $this->faker->streetAddress(), // Generate a random street address
            'city' => $this->faker->city(), // Generate a random city name
            'state' => $this->faker->state(), // Generate a random state name
            'postal_code' => $this->faker->postcode() // Generate a random postal code
        ];
    }
}
