<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This method populates the `customers` table with test data using factories.
     */
    public function run(): void
    {
        // Create 35 customers, each with 10 related invoices
        Customer::factory() // Use the CustomerFactory to generate customers
            ->count(35)     // Specify that 35 customers should be created
            ->hasInvoices(10) // For each customer, create 10 related invoices
            ->create();     // Insert the generated records into the database

        // Create 100 customers, each with 5 related invoices
        Customer::factory() 
            ->count(100)    // Create 100 customers
            ->hasInvoices(5) // Each customer will have 5 related invoices
            ->create();

        // Create another set of 100 customers, each with 3 related invoices
        Customer::factory() 
            ->count(100)    // Create 100 more customers
            ->hasInvoices(3) // Each customer will have 3 related invoices
            ->create();

        // Create 5 customers with no invoices
        Customer::factory() 
            ->count(5)      // Create 5 customers
            ->create();     // These customers will not have any invoices
    }
}
