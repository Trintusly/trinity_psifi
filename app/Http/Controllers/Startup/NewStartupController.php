<?php

namespace App\Http\Controllers\Startup;

use App\Helpers\FileSystemHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Startup\CreateNewStartupRequest;

class NewStartupController extends Controller
{
    /**
     * Show the form for creating a new startup.
     *
     * @return \Illuminate\View\View The view for creating a new startup.
     */
    public function index()
    {
        // Display the startup creation form
        return view('startup.new');
    }

    /**
     * Handle the creation of a new startup.
     *
     * @param CreateNewStartupRequest $createNewStartupRequest Validated request data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the startup view page.
     */
    public function create(CreateNewStartupRequest $createNewStartupRequest)
    {
        // Generate a unique identifier for the file name
        $rand = md5(time() * rand());

        // Upload the logo file using a helper function
        $imagePath = FileSystemHelper::uploadFile(
            $createNewStartupRequest->file('logo'),
            'images/startups', // Target directory for logo uploads
            $rand // Generated unique filename
        );

        // Create a new startup associated with the authenticated user
        $startup = auth()->user()->startups()->create([
            'display_name' => $createNewStartupRequest->display_name,
            'logo' => $rand, // Store the generated file name in the database
            'description' => $createNewStartupRequest->description,
            'industries' => strtolower(preg_replace('/[^a-zA-Z0-9, ]/', '', $createNewStartupRequest->industries)), // Clean input
            'funding_raised' => $createNewStartupRequest->funding_raised,
        ]);

        $member = auth()->user()->startupMembers()->create([
            'startup_id' => $startup->id,
            'role' => 'OWNER'
        ]);

        // Redirect to the startup view page with success
        return redirect()->route('startup.view', ['id' => $startup->id])
            ->with('success', 'Startup created successfully!');
    }
}
