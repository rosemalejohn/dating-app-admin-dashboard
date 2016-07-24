<?php

namespace App;

use App\Tenant\Conversation;
use Illuminate\Database\Eloquent\Model;

class ConversationNote extends Model
{
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

}
