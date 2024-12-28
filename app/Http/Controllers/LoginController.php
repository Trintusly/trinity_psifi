<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display the login page.
     *
     * @return \Illuminate\View\View The login view.
     */
    public function index()
    {
        // Return the login view
        return view("login");
    }

    /**
     * Handle the login process for the user.
     *
     * @param LoginRequest $loginRequest The validated login request.
     * @return \Illuminate\Http\RedirectResponse Redirect back with errors or to the user dashboard.
     */
    public function login(LoginRequest $loginRequest)
    {
        // Attempt to authenticate the user using the provided credentials
        if (!auth()->attempt($loginRequest->only('username', 'password'), true)) {
            // If authentication fails, return back with an error message
            return back()->withErrors(["Invalid credentials."]);
        }

        // If authentication succeeds, redirect to the user dashboard
        return redirect()->route("user.dashboard");
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse Redirect to the home page after logging out.
     */
    public function logout()
    {
        // Log the user out of the application
        auth()->logout();

        // Redirect to the home page after logout
        return redirect()->route("home");
    }
}
