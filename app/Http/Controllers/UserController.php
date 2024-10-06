<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()->latest()->get(); // ユーザーの投稿一覧を取得
        $followers = $user->followers; // フォロワー一覧
        $followings = $user->followings; // フォローしているユーザー一覧

        return view('users.show', compact('user', 'posts', 'followers', 'followings'));
    }
    
    public function followersFollowings(User $user)
    {
        $followers = $user->followers;  // フォロワー情報を取得
        $followings = $user->followings;  // フォロー中のユーザー情報を取得
    
        return view('users.followers_followings', compact('user', 'followers', 'followings'));
    }
}
