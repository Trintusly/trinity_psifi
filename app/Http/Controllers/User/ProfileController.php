<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($username)
    {
        $user = User::where(["username" => $username])->firstOrFail(); // Fetch the post or return 404 if not found
        return view("user.profile", ["user" => $user]);
    }
}
