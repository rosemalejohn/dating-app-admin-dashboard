<?php

namespace App\Events;

use App\Events\Event;
use App\Tenant\Conversation;
use Illuminate\Queue\SerializesModels;

class ConversationUnflagged extends Event
{
    use SerializesModels;

    public $conversation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['conversation'];
    }
}
