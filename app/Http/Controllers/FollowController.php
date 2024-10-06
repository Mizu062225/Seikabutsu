<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class FollowController extends Controller
{
    public function index()
    {
        // 自分がフォローしている人
        $followerIds = Follow::where('followee_id', Auth::id())->pluck('follower_id');
        $followers = [];
        foreach($followerIds as $followerId) {
            $follower = User::where('id', $followerId)->first();
            array_push($followers, $follower);
        }
        
         return view('follows.index', compact('followers'));
    }
    
    public function store(User $user)
    {
        auth()->user()->followings()->attach($user->id);
        return redirect()->route('user.show', $user);
    }

    public function destroy(User $user)
    {
        auth()->user()->followings()->detach($user->id);
        return redirect()->route('user.show', $user);
    }
}
