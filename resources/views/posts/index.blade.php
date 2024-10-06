    <x-app-layout>
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
   
    <button id="followButton" class="px-4 py-2 text-white bg-blue-500 rounded transition" onclick="toggleFollow()"> ALL </button>
    
    
    
    
    <!-- 全投稿 -->
    <div id="all-posts">
        <div class="tabs">
            <button class="tab-link" onclick="showTab('all')">総合</button>
            <button class="tab-link" onclick="showTab('music')">音楽</button>
            <button class="tab-link" onclick="showTab('fashion')">服飾</button>
            <button class="tab-link" onclick="showTab('art')">美術</button>
            <button class="tab-link" onclick="showTab('daily')">日常</button>
        </div>
        <div id="all" class="tab-content">
            @foreach ($posts as $post) 
                <form action="/like" method="POST">
                    @csrf
                     <!-- 1行目にユーザー名とユーザーIDを表示 -->
                     <p>
                        <a href="{{ route('user.show', ['user' => $post->user->id]) }}">
                            {{ $post->user->name }} (ID: {{ $post->user->id }})
                        </a>
                    </p
                    
                    <!-- 2行目以降に投稿内容とカテゴリーを表示 -->
                    <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="user_id" value="{{ $post->user->id }}">
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
                <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
                <p>{{ $post->body }}</p>
                
            @endforeach
        </div>
        
        <div id="fashion" class="tab-content bg-sky-500/100 text-red-600/100" style="display:none;">
            @foreach ($fashionPosts as $post)
                <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
                <p>{{ $post->body }}</p>
               
            @endforeach
        </div>
        
        <div id="art" class="tab-content" style="display:none;">
            @foreach ($artPosts as $post)
             　 <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
                <p>{{ $post->body }}</p>
                
            @endforeach
        </div>
        
        <div id="daily" class="tab-content" style="display:none;">
            @foreach ($dailyPosts as $post)
            　  <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
                <p>{{ $post->body }}</p>
                
            @endforeach
        </div>   
    </div>
    
    
　　<!-- フォロー中 -->
　　<div id="follow-posts" style="display:none;">
    　  <div class="tabs">
            <button class="tab-link" onclick="showTab('follow-all')">総合</button>
            <button class="tab-link" onclick="showTab('follow-music')">音楽</button>
            <button class="tab-link" onclick="showTab('follow-fashion')">服飾</button>
            <button class="tab-link" onclick="showTab('follow-art')">美術</button>
            <button class="tab-link" onclick="showTab('follow-daily')">日常</button>
        </div>
        
    　　<div id="follow-all" class="tab-content">
            @foreach ($followPosts as $post)
                <form action="/like" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="user_id" value="{{ $post->user->id }}">
                    <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
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
        <div id="follow-music" class="tab-content" style="display:none;">
            @foreach ($followMusicPosts as $post)
                <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
                <p>{{ $post->body }}</p>
            @endforeach
        </div>
        <div id="follow-fashion" class="tab-content bg-sky-500/100 text-red-600/100" style="display:none;">
            @foreach ($followFashionPosts as $post)
                <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
                <p>{{ $post->body }}</p>
            @endforeach
        </div>
        <div id="follow-art" class="tab-content" style="display:none;">
            @foreach ($followArtPosts as $post)
                <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
                <p>{{ $post->body }}</p>
            @endforeach
        </div>
        <div id="follow-daily" class="tab-content" style="display:none;">
            @foreach ($followDailyPosts as $post)
                <p><strong>{{ $post->user->name }} (ID: {{ $post->user->id }})</strong></p>
                <p>{{ $post->body }}</p>
            @endforeach
        </div>
　　    
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
    
        
        //切り替え
        function toggleFollow() { 
            const button = document.getElementById('followButton');
            const allPosts = document.getElementById('all-posts');
            const followPosts = document.getElementById('follow-posts');
            if (button.textContent === 'ALL') { 
                button.textContent = 'フォロー中'; 
                button.classList.remove('bg-blue-500'); 
                button.classList.add('bg-green-500'); 
                allPosts.style.display = 'none';
                followPosts.style.display = 'block';
                showTab('follow-all');
                
                
            } else { 
                button.textContent = 'ALL'; 
                button.classList.remove('bg-green-500'); 
                button.classList.add('bg-blue-500');
                allPosts.style.display = 'block';
                followPosts.style.display = 'none';
                showTab('all');
                
            }
            
        }
        
    </script>
</x-app-layout>
