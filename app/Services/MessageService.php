<?php namespace App\Services;

use App\ReturningConversation;
use App\Services\TenantService;
use App\Tenant\Conversation;
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

                $collections = $website->managed_users()
                    ->with(['user.conversation_interlocutors' => function ($query) {
                        $query
                            ->select('id', 'read', 'initiatorId', 'interlocutorId')
                            ->where('read', 0)
                            ->orWhere('read', 1)
                            ->has('initiator')
                            ->has('interlocutor')
                            ->has('messages')
                            ->with(['flagged', 'interlocutor.website',
                                'initiator' => function ($i) {
                                    $i->select('id', 'username');
                                }])
                            ->withCount('messages');
                    }])->get();

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

    public function getReturningConversations()
    {
        $websites = ReturningConversation::all()->groupBy('website_id');

        $collection = collect();

        foreach ($websites as $id) {

            $website = Website::find($id);

            $tenant->connect($website);

            $conversations = Conversation::has('returning_conversation')
                ->with('returning_conversation')
                ->get();

            $collection->push($conversations);

        }

        return $collection->flatten();
    }

}
