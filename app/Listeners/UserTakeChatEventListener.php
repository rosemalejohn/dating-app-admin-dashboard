<?php

namespace App\Listeners;

use App\Events\UserTakeChatEvent;

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
        $conversation = $event->conversation;
    }
}
