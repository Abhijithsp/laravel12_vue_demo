<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Inertia\Inertia;

class PostEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Post $post)
    {
        Gate::authorize('view', $post);

        return Inertia::render('admin/posts/Edit',['post'=>$post]);
    }
}
