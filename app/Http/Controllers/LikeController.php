<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    public function store($postId)
    {
        $post = Post::findOrFail($postId);

        // 既に「いいね」しているかチェック
        if ($post->likes()->where('user_id', auth()->id())->exists()) {
            return back()->with('message', 'いいね済み');
        }

        // 新規に「いいね」を作成
        $post->likes()->create([
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);

        // 既に「いいね」している場合、削除
        $like = $post->likes()->where('user_id', auth()->id())->first();
        if ($like) {
            $like->delete();
        }

        return back();
    }
}
