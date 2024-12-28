<?php

namespace App\Http\Controllers\Startup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListStartupController extends Controller
{
    public function index()
    {
        $startups = auth()->user()->startups()->latest()->paginate(15); // 10 is the number of startups per page
        return view("startup.list", ["startups" => $startups]);
    }
}
