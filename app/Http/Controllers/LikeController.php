<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $user_id = $request["user_id"];
        $post_id = $request["post_id"];
        $liked = Like::where("user_id", $user_id)->where("post_id", $post_id)->first();
        
        if($liked) {
            $liked->delete();
        } else {
            $like = new Like();
            $like->post_id = $post_id;
            $like->user_id = $user_id;
            $like->save();
        }
        //return redirect()->route('posts.index');
    }
}
