<x-app-layout>
    <!-- flexにして、子の要素を横並びにする。幅は画面いっぱいに広げておく -->
    <div class="flex flex-row w-full">
        <!-- 1つめの要素。こっちにpostのもろもろを入れてく。 -->
        <div class="p-6 w-full">
            <h1 class="text-xl font-bold underline p-2">Post</h1>
            <!-- postするform。サーバサイドからカテゴリもらってセレクトボックスに入れる -->
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="py-2">
                    <select class="rounded-lg border border-blue-700" name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="py-2">
                    <!-- テキストエリア。なんか高さが、tailwindで上手くいかんかったから、しゃーなしstyleべた書きした。幅は親要素の3/4 -->
                    <textarea class="rounded-lg border border-gray-300 w-3/4" name="body" style="height: 200px;" placeholder="Please input text here !!" required></textarea>
                </div>
                <div class="py-2">
                    <button class="bg-blue-500 text-white rounded-lg p-2 w-3/4" id="post-button">Post</button>
                </div>
            </form>
        </div>
        <!-- 2つめの要素。こっちにviewのもろもろを入れてく。 -->
        <div class="p-6 w-full">
            <h1 class="text-xl font-bold  underline p-2">View</h1>
            <!-- flexにして、セレクトボックスと(なんちゃって)トグルを横並び -->
            <div class="flex flex-row py-2">
                <div>
                    <!-- これもtailwindが上手くいかず、しゃーなしstyleで幅は30px右にずらしておく -->
                    <select class="rounded-lg border border-blue-700" id="view-select-box" style="margin-right: 30px;">
                        <option value="0">総合</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="border border-gray-400 rounded-lg" style="margin-right: 20px;">
                    <button class="bg-blue-500 rounded-lg p-2" id="all-post-button">All Post</button>
                    <button class="rounded-lg p-2" id="followed-post-button">Followed Post</button>
                </div>
            </div>
            <!-- 幅を親要素の3/4にしておく -->
            <ul class="list-disc pl-5 w-3/4">
                @foreach ($posts as $post)
                    <dev id="likeForm-{{ $post->id }}">
                        <li class="mb-6 border-b-2">
                            <!-- 名前と★を横並び -->
                            <div class="flex items-center space-x-2">
                                <span class="text-blue-600 px-2 rounded-lg">
                                    <a href="{{ route('user.show', ['user' => $post->user->id]) }}">
                                        {{ $post->user->name }}
                                    </a>
                                </span>
                                <button class="text-yellow-500 text-xl" id="likeButton-{{ $post->id }}" onclick="toggleLike({{ $post->id }})">★</button>
                                <span id="likeCount-{{ $post->id }}" class="text-lg">{{ $post->likes->count() }}</span>
                            </div>
                            <p class="font-bold mt-2">{{ $post->body }} - <strong>{{ $post->category->name }}</strong></p>
                        </li>
                    </dev>
                @endforeach
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        // All Postボタンをクリックしたときの処理
        document.getElementById('all-post-button').addEventListener('click', function() {
            // all postボタンの背景を青に変更して、followed postボタンの背景を白に変更する
            document.getElementById('all-post-button').classList.add('bg-blue-500');
            document.getElementById('followed-post-button').classList.remove('bg-blue-500');
            changePost();
        });

        // Followed Postボタンをクリックしたときの処理
        document.getElementById('followed-post-button').addEventListener('click', function() {
            // followed postボタンの背景を青に変更して、all postボタンの背景を白に変更する
            document.getElementById('followed-post-button').classList.add('bg-blue-500');
            document.getElementById('all-post-button').classList.remove('bg-blue-500');
            changePost();
        });

        // Viewのセレクトボックスの値が変更されたときの処理
        document.getElementById('view-select-box').addEventListener('change', function() {
            changePost();
        });

        // カテゴリーとall/followedの組み合わせによって表示する投稿を変更する
        function changePost() {
            // カテゴリーの値を取得
            var category_id = document.getElementById('view-select-box').value;
            // all/followed postボタンの値を取得
            var button = document.getElementById('all-post-button').classList.contains('bg-blue-500') ? 'all' : 'followed';
            // allの場合
            if (button === 'all') {
                // All postを取得する
                var AllPosts = @json($posts);
                // カテゴリーIDが0の場合
                if (category_id == 0) {
                    // すべての投稿を表示する
                    document.querySelectorAll('[id*="likeForm-"]').forEach(function(element) {
                        element.style.display = 'block';  // 表示する
                    });
                } else {
                    // カテゴリーIDに一致する投稿のみ表示する
                    AllPosts.forEach(function(AllPost) {
                        if (AllPost.category_id == category_id) {
                            document.getElementById('likeForm-' + AllPost.id).style.display = 'block';  // 表示する
                        } else {
                            document.getElementById('likeForm-' + AllPost.id).style.display = 'none';  // 非表示にする
                        }
                    });
                }
            }
            // followedの場合
            if (button === 'followed') {
                // Followed postを取得する
                var followPosts = @json($followPosts);
                // カテゴリーIDが0の場合
                if (category_id == 0) {
                    // すべての投稿を非表示にする
                    document.querySelectorAll('[id*="likeForm-"]').forEach(function(element) {
                        element.style.display = 'none';  // 非表示にする
                    });
                    // フォローしているユーザーのすべての投稿を表示する
                    var followPosts = @json($followPosts->pluck('id'));
                    followPosts.forEach(function(followPost) {
                        document.getElementById('likeForm-' + followPost).style.display = 'block';  // 表示する
                    });
                } else {
                    // すべての投稿を非表示にする
                    document.querySelectorAll('[id*="likeForm-"]').forEach(function(element) {
                        element.style.display = 'none';  // 非表示にする
                    });
                    // カテゴリーIDに一致する投稿のみ表示する
                    followPosts.forEach(function(followPost) {
                        if (followPost.category_id == category_id) {
                            document.getElementById('likeForm-' + followPost.id).style.display = 'block';  // 表示する
                        }
                    });
                }
            }    
        }

        // いいね機能の実装
        function toggleLike(postId) {
            let likeButton = document.getElementById('likeButton-' + postId);
            let likeCountDisplay = document.getElementById('likeCount-' + postId);
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
                console.log(data);
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
    </script>  
</x-app-layout>