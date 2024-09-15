<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();

         // 投稿を取得（例として全投稿を取得）
        $posts = Post::all();
        $musicPosts = Post::where('category_id', 1)->get(); // 音楽カテゴリ
        $fashionPosts = Post::where('category_id', 2)->get(); // 服飾カテゴリ
        $artPosts = Post::where('category_id', 3)->get(); // 美術カテゴリ
        $dailyPosts = Post::where('category_id', 4)->get(); // 日常カテゴリ
    
        return view('posts.index', compact('categories', 'posts', 'musicPosts', 'fashionPosts', 'artPosts', 'dailyPosts'));
    }
    
    public function store(Request $request)
    {
    $request->validate([
        'body' => 'required|string',
        'category_id' => 'required|integer|exists:categories,id'
    ]);

    $post = new Post();
    $post->content = $validated['content'];
    $post->category_id = $validated['category_id'];
    $post->user_id = auth()->id(); // ユーザーIDを保存
    $post->save();

    return redirect()->route('posts.index');
    }
}
