<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();

         // 投稿を取得（例として全投稿を取得）
        $posts = Post::orderBy("updated_at", "DESC")->get();
        $musicPosts = Post::where('category_id', 1)->orderBy("updated_at", "DESC")->get(); // 音楽カテゴリ
        $fashionPosts = Post::where('category_id', 2)->orderBy("updated_at", "DESC")->get(); // 服飾カテゴリ
        $artPosts = Post::where('category_id', 3)->orderBy("updated_at", "DESC")->get(); // 美術カテゴリ
        $dailyPosts = Post::where('category_id', 4)->orderBy("updated_at", "DESC")->get(); // 日常カテゴリ
        
        //フォローの投稿取得
        // フォローしているユーザーのIDを取得
        $followerIds = Follow::where('followee_id', Auth::id())->pluck('follower_id');
        $followPosts = Post::whereIn('user_id', $followerIds)->orderBy("updated_at", "DESC")->get();
        $followMusicPosts = Post::whereIn('user_id', $followerIds)->where('category_id', 1)->orderBy("updated_at", "DESC")->get();
        $followFashionPosts = Post::whereIn('user_id', $followerIds)->where('category_id', 2)->orderBy("updated_at", "DESC")->get();
        $followArtPosts = Post::whereIn('user_id', $followerIds)->where('category_id', 3)->orderBy("updated_at", "DESC")->get();
        $followDailyPosts = Post::whereIn('user_id', $followerIds)->where('category_id', 4)->orderBy("updated_at", "DESC")->get();
        return view('posts.index', compact(
            'categories', 
            'posts', 
            'musicPosts', 
            'fashionPosts', 
            'artPosts', 
            'dailyPosts', 
            'followPosts', 
            'followMusicPosts', 
            'followFashionPosts', 
            'followArtPosts', 
            'followDailyPosts'
        ));
        
        }
    
    public function store(Request $request)
    {
    $validated = $request->validate([
        'body' => 'required|string',
        'category_id' => 'required|integer|exists:categories,id'
    ]);

    $post = new Post();
    $post->body = $validated['body'];
    $post->category_id = $validated['category_id'];
    $post->user_id = auth()->id(); // ユーザーIDを保存
    $post->save();

    return redirect()->route('posts.index');
    }
}
