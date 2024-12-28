<?php

namespace App\Http\Controllers\Startup;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use Illuminate\Http\Request;

class ViewStartupController extends Controller
{
    public function index($id)
    {
        $startup = Startup::findOrFail($id);
        return view("startup.view", [
            "startup" => $startup
        ]);
    }
}
