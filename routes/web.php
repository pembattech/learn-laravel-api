<?php

use Illuminate\Support\Facades\Route; // Importing Route facade for defining routes
use Illuminate\Support\Facades\Auth; // Importing Auth facade for authentication
use Illuminate\Support\Facades\Hash; // Importing Hash facade for hashing passwords

// Route for the home page
Route::get('/', function () {
    return view('welcome'); // Returns the 'welcome' view when accessing the root URL
});

// Grouping routes that require authentication and session verification
Route::middleware([
    'auth:sanctum', // Ensures that the user is authenticated via Sanctum
    config('jetstream.auth_session'), // Uses Jetstream session authentication
    'verified', // Checks if the user's email is verified
])->group(function () {
    // Route for the dashboard, only accessible to authenticated users
    Route::get('/dashboard', function () {
        return view('dashboard'); // Returns the 'dashboard' view
    })->name('dashboard'); // Naming the route for easy reference
});

// Setup route for creating an initial admin user
Route::get('/setup', function () {
    // Credentials for the admin user
    $credentials = [
        'email' => 'admin@admin.com', // Admin email
        'password' => 'password' // Admin password
    ];

    // Check if the admin is not already logged in
    if (!Auth::attempt($credentials)) {
        // Create a new user with admin credentials
        $user = new \App\Models\User();
        $user->name = 'Admin'; // Setting the name of the user
        $user->email = $credentials['email']; // Setting the email
        $user->password = Hash::make($credentials['password']); // Hashing the password before saving
        $user->save(); // Saving the user to the database

        // Attempt to authenticate the newly created admin user
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Retrieve the authenticated user

            // Create tokens for different scopes
            $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']); // Admin token with full permissions
            $updateToken = $user->createToken('update-token', ['create', 'update']); // Token with limited permissions
            $basicToken = $user->createToken('basic-token'); // Basic token with no specific permissions

            // Return tokens in the response
            return [
                'admin' => $adminToken->plainTextToken, // Returning the plain text admin token
                'update' => $updateToken->plainTextToken, // Returning the plain text update token
                'basic' => $basicToken->plainTextToken // Returning the plain text basic token
            ];
        }
    }
});


/**
 * Key Components Explained:
 * Setup Route:
    * The /setup route is designed to create an initial admin user if one does not already exist. It uses a predefined set of credentials.
    * The Auth::attempt($credentials) method checks if the admin user can be authenticated with the provided credentials. If the user is not already logged in, a new user is created.

 * User Creation:
    * If the admin does not exist, a new User model instance is created with the admin's name, email, and a hashed password.
    * After saving the user, Auth::attempt($credentials) is called again to authenticate the newly created user.

 * Token Generation:
    * After successfully authenticating, the code generates three API tokens with different scopes:
        * admin-token for full access (create, update, delete).
        * update-token for limited access (create, update).
        * basic-token with no specific permissions.
    * These tokens are returned in the response, allowing the admin user to authenticate API requests.
 */
