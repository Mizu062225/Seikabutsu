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
        <div id="all" class="tab-content">
            @foreach ($posts as $post) 
                <form action="/like" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="user_id" value="{{ $post->user->id }}">
                    <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                    <button type="submit">
                        @if($post->likes->contains('user_id', Auth::id()))
                            <svg class="h-8 w-8 text-yellow-500"  
                                 width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="yellow-500" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M12 17.75l-6.172 3.245 1.179-6.873-4.993-4.867 6.9-1.002L12 2l3.086 6.253 6.9 1.002-4.993 4.867 1.179 6.873z" /></svg>
                        @else
                            <svg class="h-8 w-8 text-gray-500"  
                                 width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                                 stroke="currentColor" fill="gray-500" stroke-linecap="round" stroke-linejoin="round">  
                                 <path stroke="none" d="M0 0h24v24H0z"/>  
                                 <path d="M12 17.75l-6.172 3.245 1.179-6.873-4.993-4.867 6.9-1.002L12 2l3.086 6.253 6.9 1.002-4.993 4.867 1.179 6.873z" />
                            </svg>
                        @endif
                        
                    </button>
                </form>
                <p class="count-num">{{ $post->likes->count() }}</p>
            @endforeach
        </div>
        
        <div id="music" class="tab-content" style="display:none;">
            @foreach ($musicPosts as $post)
                <p>{{ $post->body }}</p>
                
            @endforeach
        </div>
        
        <div id="fashion" class="tab-content bg-sky-500/100 text-red-600/100" style="display:none;">
            @foreach ($fashionPosts as $post)
                <p>{{ $post->body }}</p>
               
            @endforeach
        </div>
        
        <div id="art" class="tab-content" style="display:none;">
            @foreach ($artPosts as $post)
                <p>{{ $post->body }}</p>
                
            @endforeach
        </div>
        
        <div id="daily" class="tab-content" style="display:none;">
            @foreach ($dailyPosts as $post)
                <p>{{ $post->body }}</p>
                
            @endforeach
        </div>
        
        <script>
            // タブの切り替え------------
            function showTab(tabId) {
                console.log(tabId);
                var tabs = document.querySelectorAll('.tab-content');
                tabs.forEach(function(tab) {
                    tab.style.display = 'none';
                });
                document.getElementById(tabId).style.display = 'block';
            }
            
            // いいね機能---------------
            const likeBtn = document.querySelector('.like-btn');
            
            likeBtn.addEventListener('click',async(e)=>{
                const clickedEl = e.target
                clickedEl.classList.toggle('liked')
                const postId = e.target.id
                const res = await fetch('/like',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ post_id: postId })
                })
                .then((res)=>res.json())
                .then((data)=>{
                    clickedEl.nextElementSibling.innerHTML = data.likesCount;
                })
                .catch(
                ()=>alert('処理が失敗しました。画面を再読み込みし、通信環境の良い場所で再度お試しください。'))
    
            })
        </script>
        
     </body>
    </x-app-layout>
</html>