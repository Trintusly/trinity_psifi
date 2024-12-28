<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\View\MakeCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class InteractController extends Controller
{
    /**
     * Add a comment to a specific post.
     *
     * @param MakeCommentRequest $makeCommentRequest Validated request containing the comment body.
     * @param int $id ID of the post to comment on.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
    public function comment(MakeCommentRequest $makeCommentRequest, $id)
    {
        // Fetch the post or fail with a 404 error if not found
        $post = Post::findOrFail($id);

        // Create a new comment associated with the authenticated user
        auth()->user()->comments()->create([
            'post_id' => $post->id,
            'body' => $makeCommentRequest->body,
        ]);

        // Redirect back to the previous page
        return back();
    }

    /**
     * Toggle like or unlike on a specific post.
     *
     * @param int $id ID of the post to like or unlike.
     * @return \Illuminate\Http\JsonResponse JSON response indicating the like status and updated like count.
     */
    public function like($id)
    {
        // Fetch the post or fail with a 404 error if not found
        $post = Post::findOrFail($id);
        $user = auth()->user();

        // Check if the user has already liked the post
        if ($post->likedByUser($user)) {
            // If liked, remove the like (unlike)
            $post->likes()->detach($user->id);
            $liked = false;
        } else {
            // If not liked, add a like
            $post->likes()->attach($user->id);
            $liked = true;
        }

        // Get the updated count of likes
        $likeCount = $post->likes()->count();

        // Return JSON response with like status and count
        return response()->json([
            'liked' => $liked,
            'like_count' => $likeCount,
        ]);
    }
}
