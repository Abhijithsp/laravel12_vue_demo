<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use Inertia\Inertia;

class PostIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $posts = Post::select('id', 'title', 'content', 'image', 'author_id', 'created_at')
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return Inertia::render('admin/posts/Index', ['posts' => $posts]);
    }
}
