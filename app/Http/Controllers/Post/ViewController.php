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
        $post = Post::with("user")->findOrFail($id); // Fetch the post or return 404 if not found
        $comments = $post->comments()->with("user")->orderByDesc("id")->paginate(15);
        return view(
            'post/view',
            [
                "post" => $post,
                "comments" => $comments
            ]
        );
    }
}
