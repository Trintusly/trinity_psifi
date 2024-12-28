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
    /**
     * Display the user's dashboard with their posts.
     *
     * @return \Illuminate\View\View The view displaying the user's dashboard.
     */
    public function index()
    {
        // Fetch posts with user and original post relationships loaded eagerly
        $posts = Post::with('user') // Always load the user for the post
            ->with(['originalPost', 'originalPostUser.user']) // Load originalPost and originalPostUser if available
            ->orderByDesc('id') // Order posts by descending ID
            ->paginate(15); // Paginate the posts (15 per page)

        // Return the dashboard view with posts
        return view("user/dashboard", [
            "posts" => $posts,
            "sharing" => false,
            "primaryStartup" => auth()->user()->primaryStartup()
        ]);
    }

    /**
     * Display the dashboard with a selected post ready for sharing.
     *
     * @param Post $post The post to be shared.
     * @return \Illuminate\View\View The view with the selected post for sharing.
     */
    public function share(Post $post)
    {
        // Eager load the user relationship for the selected post
        $postWithUser = Post::with('user')->find($post->id);

        // Return the dashboard view with the post to be shared
        return view('user/dashboard', [
            'posts' => Post::with('user')->orderByDesc('id')->paginate(15),
            "sharing" => true,
            "post" => $postWithUser,
            "primaryStartup" => auth()->user()->primaryStartup()
        ]);
    }

    /**
     * Update the user's bio.
     *
     * @param UpdateBioRequest $updateBioRequest The request containing the bio data.
     * @return \Illuminate\Http\RedirectResponse Redirect back with a success message.
     */
    public function updateBio(UpdateBioRequest $updateBioRequest)
    {
        $user = auth()->user();
        $user->bio = $updateBioRequest->bio;
        $user->save();

        // Redirect back with a success message
        return back()->with("success", "Bio updated!");
    }

    /**
     * Create a new post for the authenticated user.
     *
     * @param MakePostRequest $makePostRequest The request containing the post data.
     * @return \Illuminate\Http\RedirectResponse Redirect back with a success message.
     */
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

        // Create the post for the authenticated user
        auth()->user()->posts()->create([
            'body' => $makePostRequest->body,
            'image' => ($imagePath) ? $rand : 0, // If no image, store 0
            'is_share' => 0,
            'share_of' => 0
        ]);

        // Redirect back with a success message
        return back()->with('success', 'Posted!');
    }

    /**
     * Share an existing post on behalf of the authenticated user.
     *
     * @param SharePostRequest $sharePostRequest The request containing the share data.
     * @param Post $post The original post to be shared.
     * @return \Illuminate\Http\RedirectResponse Redirect to the newly shared post's view page.
     */
    public function sharePost(SharePostRequest $sharePostRequest, Post $post)
    {
        // Create the shared post
        $sharedPost = auth()->user()->posts()->create([
            'body' => $sharePostRequest->body ?? "",
            'image' => 0, // No image for the shared post
            'is_share' => 1,
            'share_of' => $post->id
        ]);

        // Redirect to the shared post's view page
        return redirect()->route("post.view", ["id" => $sharedPost->id]);
    }
}
