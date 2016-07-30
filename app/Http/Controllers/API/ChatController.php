<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Note;
use App\Services\MessageService;
use App\Services\ProfileService;
use App\Tenant\Conversation;
use App\Tenant\Message;
use App\Tenant\User;
use App\UserSentMessage;
use App\Website;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public $profile;

    public function __construct(ProfileService $profile)
    {
        $this->profile = $profile;
    }

    public function lobby(MessageService $msgService)
    {
        $conversations = $msgService->getConversations();
        return response()->json($conversations);
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

        return response()->json(['conversation' => $conversation, 'website' => $website]);
    }

    public function send(Request $request, Website $website, $conversation_id)
    {
        $this->validate($request, [
            'text' => 'required|min:1',
        ]);

        $conversation = Conversation::findOrFail($conversation_id);

        $message = new Message;
        $message->timeStamp = time();
        $message->senderId = $request->sender['id'];
        $message->recipientId = $request->recipient['id'];
        $message->text = $request->text;

        $conversation->messages()->save($message);

        $user = User::findOrFail($request->sender['id']);
        if ($user) {
            $this->profile->login($user);
        }

        UserSentMessage::create([
            'user_id' => auth()->user()->id,
            'website_id' => $website->id,
            'message_id' => $message->id,
        ]);

        return response()->json($message);
    }

    public function storeNotes(Request $request, Website $website, $conversation_id)
    {
        $conversation = Conversation::findOrFail($conversation_id);
        $data = [
            'website_id' => $website->id,
            'conversation_id' => $conversation->id,
            'note' => $request->note,
            'type' => $request->type,
        ];
        $note = Note::create($data);

        return response()->json($note);
    }
}
