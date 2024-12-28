<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\View\MakeCommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class InteractController extends Controller
{

    public function comment(MakeCommentRequest $makeCommentRequest, $id)
    {
        $post = Post::findOrFail($id);

        auth()->user()->comments()->create([
            "post_id" => $post->id,
            "body" => $makeCommentRequest->body
        ]);

        return back();
    }

    public function like($id)
    {
        $post = Post::findOrFail($id);
        $user = auth()->user();

        if ($post->likedByUser($user)) {
            // Unlike the post
            $post->likes()->detach($user->id);
            $liked = false;
        } else {
            // Like the post
            $post->likes()->attach($user->id);
            $liked = true;
        }

        $likeCount = $post->likes()->count();

        return response()->json([
            'liked' => $liked,
            'like_count' => $likeCount,
        ]);
    }

}
