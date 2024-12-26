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
}
