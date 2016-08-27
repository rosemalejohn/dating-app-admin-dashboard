<?php namespace App\Services;

use App\ReturningConversation;
use App\Services\TenantService;
use App\Tenant\Conversation;
use App\Website;
use Image;

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
        $returning_conversations = ReturningConversation::where('already_sent', false)->get();

        $collection = collect();

        foreach ($returning_conversations as $returning_conversation) {

            $website = Website::find($returning_conversation->website_id);

            if ($website) {
                $this->tenant->connect($website);

                $conversation = Conversation::whereId($returning_conversation->conversation_id)
                    ->with('returning_conversation', 'interlocutor.website', 'initiator', 'flagged')
                    ->withCount('messages')
                    ->first();

                $collection->push($conversation);
            }

        }
        return $collection;
    }

    public function sendAttachment($photo, $message)
    {
        $filename = str_random(13) . '.jpg';

        $image = Image::make($photo);
        $image->save('uploads/' . $filename);

        $attachment = $message->attachments()->create([
            'hash' => str_random(13),
            'fileName' => $filename,
            'fileSize' => $image->filesize(),
        ]);

        $this->tenant->ftp()->changeDir('ow_userfiles/plugins/mailbox/attachments');

        $this->tenant->ftp()->uploadFile(
            public_path('uploads/' . $filename),
            "attachment_{$attachment->id}_{$attachment->hash}_{$attachment->fileName}",
            FTP_BINARY);

        return $attachment;
    }

}
