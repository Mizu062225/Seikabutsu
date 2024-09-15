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
         <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <textarea name="body" placeholder="好きにポストしよう" required></textarea>
            <div class="category">
                <h2>カテゴリー</h2>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
             <button type="submit">ポスト</button>
        </form>

        
        <div class="tabs">
            <button class="tab-link" onclick="showTab('all')">総合</button>
            <button class="tab-link" onclick="showTab('music')">音楽</button>
            <button class="tab-link" onclick="showTab('fashion')">服飾</button>
            <button class="tab-link" onclick="showTab('art')">美術</button>
            <button class="tab-link" onclick="showTab('daily')">日常</button>
        </div>
        
                <!-- 各タブに対応する投稿一覧を表示 -->
        <div id="all" class="tab-content" style="display:none;">
            @foreach ($posts as $post) 
                <p>{{ $post->content }} - <strong>{{ $post->category->name }}</strong></p> 
                 <!-- いいねボタン -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        {{ $post->isLikedBy(auth()->user()) ? 'いいねを解除' : 'いいね' }}
                    </button>
                    <span>{{ $post->likes->count() }} いいね</span>
                </form>
            @endforeach
        </div>
        
        <div id="music" class="tab-content" style="display:none;">
            @foreach ($musicPosts as $post)
                <p>{{ $post->content }}</p>
                 <!-- いいねボタン -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        {{ $post->isLikedBy(auth()->user()) ? 'いいねを解除' : 'いいね' }}
                    </button>
                    <span>{{ $post->likes->count() }} いいね</span>
                </form>
            @endforeach
        </div>
        
        <div id="fashion" class="tab-content" style="display:none;">
            @foreach ($fashionPosts as $post)
                <p>{{ $post->content }}</p>
                <!-- いいねボタン -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        {{ $post->isLikedBy(auth()->user()) ? 'いいねを解除' : 'いいね' }}
                    </button>
                    <span>{{ $post->likes->count() }} いいね</span>
                </form> 
            @endforeach
        </div>
        
        <div id="art" class="tab-content" style="display:none;">
            @foreach ($artPosts as $post)
                <p>{{ $post->content }}</p>
                 <!-- いいねボタン -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        {{ $post->isLikedBy(auth()->user()) ? 'いいねを解除' : 'いいね' }}
                    </button>
                    <span>{{ $post->likes->count() }} いいね</span>
                </form>
            @endforeach
        </div>
        
        <div id="daily" class="tab-content" style="display:none;">
            @foreach ($dailyPosts as $post)
                <p>{{ $post->content }}</p>
                 <!-- いいねボタン -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        {{ $post->isLikedBy(auth()->user()) ? 'いいねを解除' : 'いいね' }}
                    </button>
                    <span>{{ $post->likes->count() }} いいね</span>
                </form>
            @endforeach
        </div>
        
        <script>
            function showTab(tabId) {
                var tabs = document.querySelectorAll('.tab-content');
                tabs.forEach(function(tab) {
                    tab.style.display = 'none';
                });
                document.getElementById(tabId).style.display = 'block';
            }
        </script>
     </body>
    </x-app-layout>
</html>