<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class FeedController extends Controller
{
    public function index()
    {
        $posts = Post::with('user') // Always load the user for the post
            ->with(['originalPost', 'originalPostUser.user']) // Load originalPost and originalPostUser if available
            ->orderByDesc('id') // Order posts by descending ID
            ->paginate(15); // Paginate the posts (15 per page)

        return view("feed", compact('posts'));
    }
}
