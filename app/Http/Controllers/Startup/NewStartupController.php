<?php

namespace App\Http\Controllers\Startup;

use App\Helpers\FileSystemHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Startup\CreateNewStartupRequest;
use Illuminate\Http\Request;

class NewStartupController extends Controller
{
    public function index()
    {
        return view("startup.new");
    }

    public function create(CreateNewStartupRequest $createNewStartupRequest)
    {
        $rand = md5(time() * rand());

        // Save the file using the helper function to the 'public/images/posts' directory
        $imagePath = FileSystemHelper::uploadFile(
            $createNewStartupRequest->file('logo'),
            'images/startups',  // specify the directory
            $rand  // pass the generated filename
        );

        // Use the 'startups' relationship to create the startup for the authenticated user
        $startup = auth()->user()->startups()->create([
            'display_name' => $createNewStartupRequest->display_name,
            'logo' => $rand, // Assuming logo handling is done elsewhere
            'description' => $createNewStartupRequest->description,
            'industries' => strtolower(preg_replace('/[^a-zA-Z0-9, ]/', '', $createNewStartupRequest->industries)),
            'funding_raised' => $createNewStartupRequest->funding_raised,
        ]);

        // Redirect to the startup show page with success message
        return redirect()->route("startup.view", ["id" => $startup->id]);
    }
}
