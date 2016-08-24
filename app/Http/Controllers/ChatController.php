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
        $conversations = $this->msgService->getConversations()
            ->merge($this->msgService->getReturningConversations());

        return view('chat.lobby')->with(compact('conversations'));
    }

    public function conversation(Website $website, $conversation_id)
    {
        $conversation = Conversation::whereId($conversation_id)->with(
            'initiator.avatar',
            'interlocutor.avatar',
            'initiator.profile',
            'interlocutor.profile',
            'notes',
            'interlocutor.website')->first();

        if (auth()->user()->can('view', $conversation)) {
            event(new UserTakeChatEvent($website, $conversation));
            return view('chat.conversation')->with(compact('website', 'conversation'));
        }
        abort(403);
    }

    public function nextConversation()
    {
        $conversation = $this->msgService->getConversations()->first();

        $website = $conversation->interlocutor->website;

        if ($website) {
            $website = $website->first();

            return redirect()->to('/chat/' . $website->id . '/' . $conversation->id);
        }
    }
}
