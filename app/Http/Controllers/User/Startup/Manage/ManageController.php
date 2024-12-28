<?php

namespace App\Http\Controllers\User\Startup\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    public function index()
    {
        return view("user.startup.manage.index");
    }
}
