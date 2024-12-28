<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Settings\UpdatePictureRequest;
use Illuminate\Http\Request;
use App\Helpers\FileSystemHelper;

class SettingsController extends Controller
{
    /**
     * Display the user's settings page.
     *
     * @return \Illuminate\View\View The settings page view.
     */
    public function index()
    {
        // Return the settings view
        return view("user/settings");
    }

    /**
     * Update the user's profile picture.
     *
     * @param UpdatePictureRequest $updatePictureRequest The request containing the new profile picture.
     * @return \Illuminate\Http\RedirectResponse Redirect back with a success or error message.
     */
    public function updatePicture(UpdatePictureRequest $updatePictureRequest)
    {
        // Generate a random filename based on current timestamp and random number
        $rand = md5(time() * rand());

        // Upload the file using the helper and get the file path
        $filePath = FileSystemHelper::uploadFile(
            $updatePictureRequest->file('picture'), // The uploaded file
            'images/users',  // Directory to store the file
            $rand  // Generated random filename
        );

        // Get the authenticated user
        $u = auth()->user();

        // Update the user's picture field with the new file name
        $u->picture = $rand;
        $u->save();

        // If file upload is successful, return with a success message
        if ($filePath) {
            return back()->with('success', "Profile picture updated successfully!");
        }

        // If file upload failed, return with an error message
        return back()->with('error', 'Failed to upload file.');
    }
}
