<x-app-layout>
<div class="profile">
        <h2>{{ $user->name }}のプロフィール</h2>
        
         <!-- フォロー数とフォロワー数をまとめたリンクボタン -->
        <a href="{{ route('user.followers_followings', $user) }}" class="btn btn-info">
             {{ $followings->count() }} フォロー中 / {{ $followers->count() }} フォロワー
        </a>
        
        @if(auth()->user()->id !== $user->id) <!-- 自分のプロフィールではない場合 -->
            @if(auth()->user()->isFollowing($user))
                <!-- フォロー中の場合 -->
                <form action="{{ route('user.unfollow', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">フォロー中</button>
                </form>
            @else
                <!-- フォローしていない場合 -->
                <form action="{{ route('user.follow', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">フォローする</button>
                </form>
            @endif
        @endif
    
        <h3>投稿</h3>
        @foreach($posts as $post)
            <div>{{ $post->body }}</div>
        @endforeach
    </div>
</x-app-layout>