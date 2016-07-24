<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tenant\Conversation;
use App\Website;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function send(Request $request, Website $website, Conversation $conversation)
    {
        dd($request->all());
        $time = time();
        $conversation->messages()->create([
            'timeStamp' => $time,
            'senderId' => $request->sender->id,
            'recipientId' => $request->recipient->id,
            'text' => $request->text,
        ]);
    }

    public function saveNotes(Request $request, Website $website, Conversation $conversation)
    {

    }
}
