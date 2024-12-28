<?php

namespace App\Http\Controllers\User;

use App\Helpers\FileSystemHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Dashboard\MakePostRequest;
use App\Http\Requests\User\Dashboard\SharePostRequest;
use App\Http\Requests\User\Dashboard\UpdateBioRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::with('user') // Always load the user for the post
        ->with(['originalPost', 'originalPostUser.user']) // Always attempt to load originalPost and originalPostUser for every post
        ->orderByDesc('id') // Order posts by descending ID
        ->paginate(15); // Pagination
    
    
    
        
        return view(
            "user/dashboard",
            [
                "posts" => $posts,
                "sharing" => false
            ]
        );
    }
    public function share(Post $post)
    {
        // Eager load the 'user' relationship for the selected post
        $postWithUser = Post::with('user')->find($post->id);

        return view(
            'user/dashboard',
            [
                'posts' => Post::with('user')->orderByDesc('id')->paginate(15),
                "sharing" => true,
                "post" => $postWithUser
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
        // Initialize image path as null
        $imagePath = null;

        // Check if a picture is uploaded
        if ($makePostRequest->hasFile('picture')) {
            // Generate a unique filename using md5(time() * rand())
            $rand = md5(time() * rand());

            // Save the file using the helper function to the 'public/images/posts' directory
            $imagePath = FileSystemHelper::uploadFile(
                $makePostRequest->file('picture'),
                'images/posts',  // specify the directory
                $rand  // pass the generated filename
            );
        }

        // Create the post
        auth()->user()->posts()->create([
            'body' => $makePostRequest->body,
            'image' => ($imagePath) ? $rand : 0, // If no image, store 0,
            'is_share' => 0,
            'share_of' => 0
        ]);

        return back()->with(
            'success',
            'Posted!'
        );
    }

    public function sharePost(SharePostRequest $sharePostRequest, Post $post)
    {
        $p = auth()->user()->posts()->create([
            'body' => $sharePostRequest->body ?? "",
            'image' => 0, // If no image, store 0,
            'is_share' => 1,
            'share_of' => $post->id
        ]);

        return redirect()->route("post.view", ["id" => $p->id]);
    }
}
