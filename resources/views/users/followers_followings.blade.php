<x-app-layout>
    <div class="follow-tab-page">
        <h2>{{ $user->name }}のフォロー / フォロワー</h2>

        <!-- タブメニュー -->
        <div class="tabs">
            <button class="tab-link" onclick="showTab('followings')">フォロー中</button>
            <button class="tab-link" onclick="showTab('followers')">フォロワー</button>
        </div>

        <!-- タブコンテンツ -->
        <div class="tab-content" id="followings" style="display:none;">
            <h3>フォロー中のユーザー一覧</h3>
            @foreach($followings as $following)
            <ul>
                <a href="{{ route('user.show', ['user' => $following->id]) }}">
                            {{ $following->name }} (ID: {{ $following->id }})
                </a>
            </ul>
            @endforeach
        </div>
        
         <div class="tab-content" id="followers" style="display:block;">
            <h3>フォロワー一覧</h3>
            @foreach($followers as $follower)
            <ul>
                <a href="{{ route('user.show', ['user' => $follower->id]) }}">
                            {{ $follower->name }} (ID: {{ $follower->id }})
                </a>
            </ul>
            @endforeach
        </div>
    </div>

    <!-- JavaScriptでタブの表示を制御 -->
    <script>
        function showTab(tabName) {
            var i;
            var x = document.getElementsByClassName("tab-content");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";  // すべてのタブを非表示
            }
            document.getElementById(tabName).style.display = "block";  // 選択されたタブを表示
        }
    </script>
</x-app-layout>