<x-app-layout>
    <x-slot name="header">フォロー中のユーザー</x-slot>
    <div>
        @foreach ($followers as $follower)
            <p>{{ $follower->id }}: {{ $follower->name }}</p>
        @endforeach
    </div>
</x-app-layout>
 