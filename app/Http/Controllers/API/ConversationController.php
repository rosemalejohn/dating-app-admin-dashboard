<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tenant\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function send(Request $request, Conversation $conversation)
    {
        $time = time();
        $conversation->messages()->create([
            'timeStamp' => $time,
            'senderId' => $request->sender_id,
            'recipientId' => $request->recipient_id,
            'text' => $request->text,
        ]);
    }
}
