<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated_data=$request->validate([
            'title'=>'required',
            'content'=>'required',
            'image'=>'required|image',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated_data['image'] = $path;
        }

        $post=new Post();
        $post->title=$validated_data['title'];
        $post->content=$validated_data['content'];
        $post->image=$validated_data['image'];
        $post->author_id=Auth::id();
        $post->save();

        return to_route('posts.index');
    }
}
