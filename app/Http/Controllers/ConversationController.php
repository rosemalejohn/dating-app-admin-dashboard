<?php

namespace App\Http\Controllers;

use App\Services\TenantService;
use App\Website;

class ConversationController extends Controller
{
    public function index(TenantService $tenant)
    {

        $websites = Website::orderBy('created_at', 'desc')->get();

        $conversations = collect();

        foreach ($websites as $website) {

            $tenant->connect($website);

            $managed_users = $website->managed_users()->with([
                'user.conversation_interlocutors.initiator.avatar',
                'user.conversation_interlocutors.interlocutor.avatar',
                'user.conversation_interlocutors.messages' => function ($query) {
                    $query->unread()->with('sender.avatar', 'recipient.avatar');
                },
            ])->get();

            foreach ($managed_users as $managed_user) {
                $convo = $managed_user->user->conversation_interlocutors;
                if ($convo) {
                    $conversations->push($convo);
                }
            }
        }

        $conversations = $conversations->flatten()->take(50);

        return view('conversations.index')->with(compact('conversations'));
    }
}
