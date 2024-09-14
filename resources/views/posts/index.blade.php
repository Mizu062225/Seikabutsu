<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>HOME</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <x-app-layout>
    <body>
        <h1>タイムライン</h1>

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <textarea name="body" placeholder="好きにポストしよう" required></textarea>
            <select name="category_id" required>
                <option value="" disabled selected>カテゴリを選択</option>
                <option value="1">音楽</option>
                <option value="2">服飾</option>
                <option value="3">美術</option>
                <option value="4">日常</option>
            </select>
            <button type="submit">ポスト</button>
        </form>
        
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <p>{{ $post->user->name }}: {{ $post->body }}</p>
                    <small>{{$post->created_at->diffForHumans()}}</small>
                    <!-- いいねボタン -->
                    @if ($post->likes->where('user_id', auth()->id())->count())
                        <form action="{{ route('posts.unlike', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">いいねを取り消す</button>
                        </form>
                    @else
                        <form action="{{ route('posts.like', $post) }}" method="POST">
                            @csrf
                            <button type="submit">いいね</button>
                        </form>
                    @endif
            
                    <!-- いいね数表示 -->
                    <p>いいね数: {{ $post->likes->count() }}</p>
                 </div>
            @endforeach
        </div>
    </body>
    </x-app-layout>
</html>