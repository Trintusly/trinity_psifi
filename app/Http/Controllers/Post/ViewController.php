<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;

class ViewController extends Controller
{
    /**
     * Display a single post with its details, comments, and likes.
     *
     * @param int $id ID of the post to display.
     * @return \Illuminate\View\View The view displaying the post details.
     */
    public function index($id)
    {
        // Fetch the post with related data:
        // - 'user': The owner of the post.
        // - 'originalPost.user': User who created the original post (if it's a repost).
        // - 'likes': Users who liked the post.
        $post = Post::with([
            'user',
            'originalPost.user',
            'likes'
        ])->findOrFail($id);

        // Fetch comments associated with the post, including user details,
        // sorted by most recent first, and paginated (15 per page).
        $comments = $post->comments()
            ->with('user')
            ->orderByDesc('id')
            ->paginate(15);

        // Fetch all users who liked the post.
        $likedUsers = $post->likes()->get();

        // Pass data to the view
        return view('post/view', [
            'post' => $post,
            'comments' => $comments,
            'likes' => $likedUsers,
        ]);
    }
}
