<?php

namespace App\Policies;

use App\Tenant\Conversation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Conversation $conversation)
    {

        $active_conversation = $conversation->active;

        if ($active_conversation) {
            if ($active_conversation->user_id == $user->id) {
                return true;
            }
            return false;
        }
        return true;
    }
}
