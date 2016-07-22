<?php

namespace App\Http\Controllers;

use App\Website;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = collect();

        $websites = Website::all();

        foreach ($websites as $website) {
            connectToTenant($website);

            // get managed users with conversation only.

            $managed_users = $website->managed_users()->with([
                'user.conversation_initiators.initiator',
                'user.conversation_initiators.interlocutor',
                'user.conversation_initiators.messages.recipient.profile',
                'user.conversation_initiators.messages.sender.profile',
            ])->get();

            foreach ($managed_users as $manage_user) {
                $conversation = $manage_user->user->conversation_initiators;
                if (!$conversation->isEmpty()) {
                    $conversations->push($conversation);
                }
            }

        }

        // dd($conversations);

        return view('conversations.index')->with(compact('conversations'));
    }
}
