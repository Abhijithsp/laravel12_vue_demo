<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts=Post::all();
        return Inertia::render('admin/posts/Index',['posts'=>$posts]);
    }
}
