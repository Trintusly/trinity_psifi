<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\View\MakeCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index($id)
    {
        $post = Post::with([
            'user',                  // Owner of the post
            'originalPost.user',     // User who created the original post (if it's a repost)
            'likes'                  // Users who liked the post (via pivot)
        ])->findOrFail($id);
        
        // Fetch comments with user details
        $comments = $post->comments()
            ->with('user') // Include user details for each comment
            ->orderByDesc('id')
            ->paginate(15);
        
        // Fetch users who liked the post
        $likedUsers = $post->likes()->get();
        

        return view(
            'post/view',
            [
                "post" => $post,
                "comments" => $comments,
                "likes" => $likedUsers
            ]
        );
    }
}
