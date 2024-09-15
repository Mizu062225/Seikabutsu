<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    public function toggleLike($postId)
    {
        $post = Post::findOrFail($postId);
        $user = auth()->user();
    
        // すでにいいねしているか確認
        if ($post->isLikedBy($user)) {
            // いいねを削除
            $post->likes()->where('user_id', $user->id)->delete();
            return redirect()->back()->with('success', 'いいねを解除しました');
        } else {
            // いいねを追加
            $post->likes()->create(['user_id' => $user->id]);
            return redirect()->back()->with('success', 'いいねしました');
        }
    }
}
