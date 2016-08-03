<?php

namespace App\Listeners;

use App\Events\UserTakeChatEvent;
use Illuminate\Database\QueryException;

class UserTakeChatEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserTakeChatEvent  $event
     * @return void
     */
    public function handle(UserTakeChatEvent $event)
    {
        $user = auth()->user();
        $website = $event->website;
        $conversation = $event->conversation;

        try {
            $user->active_conversation()->create(['website_id' => $website->id, 'conversation_id' => $conversation->id]);
        } catch (QueryException $ex) {

        }
    }
}
