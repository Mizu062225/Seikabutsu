<x-app-layout>
    <!-- 投稿フォーム -->
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

    <!-- フォロー中/全投稿の切り替えボタン -->
    <button id="followButton" class="px-4 py-2 text-white bg-blue-500 rounded transition" onclick="toggleFollow()">ALL</button>

    <!-- 全投稿 -->
    <div id="all-posts">
        <div class="tabs">
            <button class="tab-link" onclick="showTab('all')">総合</button>
            <button class="tab-link" onclick="showTab('music')">音楽</button>
            <button class="tab-link" onclick="showTab('fashion')">服飾</button>
            <button class="tab-link" onclick="showTab('art')">美術</button>
            <button class="tab-link" onclick="showTab('daily')">日常</button>
        </div>

        <!-- 全投稿のタブごとの表示 -->
        <div id="all" class="tab-content">
            @foreach ($posts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p>
                            <a href="{{ route('user.show', ['user' => $post->user->id]) }}">
                                {{ $post->user->name }} (ID: {{ $post->user->id }})
                            </a>
                        </p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="user_id" value="{{ $post->user->id }}">

                        <!-- いいねボタン -->
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- 各カテゴリーの投稿 -->
        <div id="music" class="tab-content" style="display:none;">
            @foreach ($musicPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        
        <div id="fashion" class="tab-content" style="display:none;">
            @foreach ($fashionPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        
        <div id="art" class="tab-content" style="display:none;">
            @foreach ($artPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        
         <div id="daily" class="tab-content" style="display:none;">
            @foreach ($dailyPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        
    <!-- フォロー中の投稿 -->
    <div id="follow-posts" style="display:none;">
        <div class="tabs">
            <button class="tab-link" onclick="showTab('follow-all')">総合</button>
            <button class="tab-link" onclick="showTab('follow-music')">音楽</button>
            <button class="tab-link" onclick="showTab('follow-fashion')">服飾</button>
            <button class="tab-link" onclick="showTab('follow-art')">美術</button>
            <button class="tab-link" onclick="showTab('follow-daily')">日常</button>
        </div>

        <!-- フォロー中の投稿一覧 -->
        <div id="follow-all" class="tab-content">
            @foreach ($followPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>

        <div id="follow-music" class="tab-content">
            @foreach ($followMusicPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        
        <div id="follow-fashion" class="tab-content">
            @foreach ($followFashionPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        
        <div id="follow-art" class="tab-content">
            @foreach ($followArtPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
        
        <div id="follow-daily" class="tab-content">
            @foreach ($followDailyPosts as $post)
                <div class="post-item">
                    <form action="/like" method="POST" id="likeForm-{{ $post->id }}">
                        @csrf
                        <p><a href="{{ route('user.show', ['user' => $post->user->id]) }}">{{ $post->user->name }} (ID: {{ $post->user->id }})</a></p>
                        <p>{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        <div class="flex items-center space-x-2">
                            <button type="button" id="likeButton-{{ $post->id }}" class="text-yellow-500 text-3xl transition duration-300" onclick="toggleLike({{ $post->id }})">
                                ★
                            </button>
                            <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>

    <script>
        // タブの切り替え機能
        function showTab(tabId) {
            var tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(function(tab) {
                tab.style.display = 'none';
            });
            document.getElementById(tabId).style.display = 'block';
        }

        // 全投稿とフォロー中投稿の切り替え
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

        // いいね機能の実装
        function toggleLike(postId) {
            const likeButton = document.getElementById('likeButton-' + postId);
            const likeCountDisplay = document.getElementById('likeCount-' + postId);
            let isLiked = likeButton.classList.contains('text-red-500');
            let likeCount = parseInt(likeCountDisplay.textContent);

            fetch("{{ route('like.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    post_id: postId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'liked') {
                    likeButton.classList.remove('text-yellow-500');
                    likeButton.classList.add('text-red-500');
                    likeCount++;
                } else {
                    likeButton.classList.remove('text-red-500');
                    likeButton.classList.add('text-yellow-500');
                    likeCount--;
                }
                likeCountDisplay.textContent = likeCount;
            })
            .catch(error => console.error('Error:', error));
        }
        
        document.addEventListener('DOMContentLoaded', function () {
            const allTabs = document.querySelectorAll('.tab-content button');
            allTabs.forEach(button => {
                button.addEventListener('click', function () {
                    const postId = this.getAttribute('data-post-id');
                    toggleLike(postId);
                });
            });
        });
    </script>
</x-app-layout>
