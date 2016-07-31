<?php

namespace App\Http\Controllers;

use App\Events\UserTakeChatEvent;
use App\Services\MessageService;
use App\Tenant\Conversation;
use App\Website;

class ChatController extends Controller
{

    public function __construct(MessageService $msgService)
    {
        $this->msgService = $msgService;
    }

    public function lobby()
    {
        $conversations = $this->msgService->getConversations();
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
            'notes',
            'interlocutor.website')->first();
        event(new UserTakeChatEvent($conversation));
        return view('chat.conversation')->with(compact('website', 'conversation'));
    }
}
