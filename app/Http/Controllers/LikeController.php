<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
         // ユーザーがすでにその投稿に対していいねしているかを確認
        $like = Like::where('user_id', auth()->id())
                    ->where('post_id', $request->post_id)
                    ->first();

        if ($like) {
            // すでにいいねしている場合は解除
            $like->delete();
            return response()->json(['status' => 'unliked']);
        } else {
            // まだいいねしていない場合はいいねを追加
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $request->post_id,
            ]);
            return response()->json(['status' => 'liked']);
        }
    }
}