<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('frontend.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        abort_unless($post->status === 'published' && $post->published_at?->isPast(), 404);

        return view('frontend.posts.show', compact('post'));
    }
}
