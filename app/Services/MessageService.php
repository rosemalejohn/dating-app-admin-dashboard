<?php namespace App\Services;

use App\Services\TenantService;
use App\Website;

class MessageService
{

    public $tenant;

    public function __construct(TenantService $tenant)
    {
        $this->tenant = $tenant;
    }

    public function getConversations()
    {
        $websites = Website::orderBy('created_at', 'desc')->get();

        $conversations = collect();

        foreach ($websites as $website) {
            if (auth()->user()->can('view', $website)) {

                $this->tenant->connect($website);

                $collections = $website->managed_users()->with([
                    'user.conversation_interlocutors' => function ($query) {
                        $query->where('read', 0)
                            ->orWhere('read', 1)
                            ->has('initiator')
                            ->has('interlocutor')
                            ->with('interlocutor.website', 'initiator', 'messages');
                    },
                ])->get();

                $filtered = $collections->filter(function ($collection) {
                    return $collection->user->conversation_interlocutors;
                });

                foreach ($filtered as $filter) {
                    $conversations->push($filter->user->conversation_interlocutors);
                }
            }
        }

        $conversations = $conversations->flatten()->sortBy('createStamp')->values();
        return $conversations;
    }

    public function getMessagePerDay(Website $website)
    {

    }

    public function countMessagesPerDay($date)
    {

    }

}
