<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the profile of a specific user based on their username.
     *
     * @param string $username The username of the user whose profile is to be displayed.
     * @return \Illuminate\View\View The view displaying the user's profile.
     */
    public function index($username)
    {
        // Fetch the user by their username or return a 404 error if not found
        $user = User::where('username', $username)->firstOrFail();

        // Return the profile view with the user data
        return view("user.profile", ["user" => $user, "primaryStartup" => $user->primaryStartup()]);
    }
}
