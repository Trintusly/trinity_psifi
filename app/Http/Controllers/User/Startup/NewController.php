<?php

namespace App\Http\Controllers\User\Startup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewController extends Controller
{
    public function index()
    {
        return view("user.startup.new");
    }
}
