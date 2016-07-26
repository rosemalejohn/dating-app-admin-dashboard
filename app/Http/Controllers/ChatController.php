<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use App\Tenant\Conversation;
use App\Website;

class ChatController extends Controller
{

    public function lobby(MessageService $msgService)
    {
        $conversations = $msgService->getConversations();
        return view('chat.lobby')->with(compact('conversations'));
    }

    public function conversation(Website $website, $conversation_id)
    {
        $conversation = Conversation::whereId($conversation_id)->with(
            'messages.sender.avatar',
            'messages.recipient.avatar',
            'initiator.avatar',
            'interlocutor.avatar',
            'initiator.profile',
            'interlocutor.profile',
            'notes')->first();
        return view('chat.conversation')->with(compact('website', 'conversation'));
    }
}
