<?php

namespace App\Http\Controllers\Startup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageStartupController extends Controller
{
    public function list()
    {
        return view("startup.manage.list");
    }
}
