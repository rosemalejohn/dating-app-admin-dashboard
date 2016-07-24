<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use App\Services\TenantService;
use App\Tenant\Conversation;
use App\Website;

class ChatController extends Controller
{

    public $tenant;

    public function __construct(TenantService $tenant)
    {
        $this->middleware('tenant', ['only' => 'conversation']);

        $this->tenant = $tenant;
    }

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
            'interlocutor.profile')->first();
        return view('chat.conversation')->with(compact('website', 'conversation'));
    }
}
