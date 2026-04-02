<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


use Illuminate\Support\Facades\Storage;

class PostDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Post $post)
    {
        Gate::authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return to_route('posts.index')->with('success', 'Post and image deleted successfully.');

    }
}
