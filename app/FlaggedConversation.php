<?php

namespace App;

use App\Tenant\Conversation;
use Illuminate\Database\Eloquent\Model;

class FlaggedConversation extends Model
{

    protected $fillable = ['conversation_id', 'user_id'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

}
