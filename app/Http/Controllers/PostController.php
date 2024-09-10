<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Post $post)
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }
    
    public function store(Request $request)
    {
    $request->validate([
        'body' => 'required|string',
    ]);

    auth()->user()->posts()->create($request->all());

    return redirect()->route('posts.index');
    }
}
