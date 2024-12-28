<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function login(LoginRequest $loginRequest)
    {

        if (!auth()->attempt($loginRequest->only('username', 'password'), true)) {
            return back()->withErrors(["Invalid credentials."]);
        }

        return redirect()->route("user.dashboard");
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route("home");
    }
}
