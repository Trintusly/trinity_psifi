<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\MakePostRequest;
use App\Http\Requests\User\Dashboard\UpdateBioRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view(
            "user/dashboard",
            [
                "posts" => Post::with("user")->orderByDesc("id")->paginate(15)
            ]
        );
    }

    public function updateBio(UpdateBioRequest $updateBioRequest)
    {
        $u = auth()->user();
        $u->bio = $updateBioRequest->bio;
        $u->save();

        return back()->with(
            "success",
            "Bio updated!"
        );
    }

    public function makePost(MakePostRequest $makePostRequest)
    {
        auth()->user()->posts()->create([
            "body" => $makePostRequest->body,
            "image" => 0
        ]);

        return back();
    }
}
