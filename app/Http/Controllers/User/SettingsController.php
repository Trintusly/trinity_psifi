<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Settings\UpdatePictureRequest;
use Illuminate\Http\Request;
use App\Helpers\FileSystemHelper;
class SettingsController extends Controller
{
    public function index()
    {
        return view("user/settings");
    }

    public function updatePicture(UpdatePictureRequest $updatePictureRequest)
    {
        $rand = md5(time() * rand());

        $filePath = FileSystemHelper::uploadFile($updatePictureRequest->file('picture'), 'images/users', $rand);

        $u = auth()->user();
        $u->picture = $rand;
        $u->save();

        if ($filePath) {
            return back()->with('success', "Profile picture updated successfully!");
        }

        return back()->with('error', 'Failed to upload file.');
    }
}
