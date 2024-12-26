<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view("register");
    }

    public function register(RegisterRequest $registerRequest)
    {
        User::create([
            "username" => $registerRequest->username,
            "email" => $registerRequest->email,
            "password" => $registerRequest->password,
        ]);

        return redirect()->route("login");
    }
}
