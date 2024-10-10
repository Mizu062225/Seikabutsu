<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;


class MessageController extends Controller
{
    public function store(Request $request, Chat $chat)
    {
        $message = $chat->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);

        // リアルタイムでメッセージをブロードキャスト（Pusher）
        broadcast(new MessageSent($chat, $message))->toOthers();

        return response()->json(['message' => $message]);
    }
}
