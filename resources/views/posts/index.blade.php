<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>HOME</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>タイムライン</h1>

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <textarea name="body" placeholder="好きにポストしよう" required></textarea>
            <button type="submit">ポスト</button>
        </form>
        
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <p>{{ $post->user->name }}: {{ $tweet->body }}</p>
                    <small>{{$post->create_at->diffForHumans()}}</small>
                </div>
            @endforeach
        </div>
    </body>
</html>