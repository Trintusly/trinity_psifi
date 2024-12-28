<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display the registration page.
     *
     * @return \Illuminate\View\View The registration view.
     */
    public function index()
    {
        // Return the registration view
        return view("register");
    }

    /**
     * Handle the registration process for a new user.
     *
     * @param RegisterRequest $registerRequest The validated registration request.
     * @return \Illuminate\Http\RedirectResponse Redirect to the login page after registration.
     */
    public function register(RegisterRequest $registerRequest)
    {
        // Create a new user in the database with the validated data
        User::create([
            "username" => $registerRequest->username,   // Username of the new user
            "email"    => $registerRequest->email,         // Email of the new user
            "password" => bcrypt($registerRequest->password),  // Password hashed using bcrypt
        ]);

        // Redirect to the login page after successful registration
        return redirect()->route("login");
    }
}
