<?php

namespace App;

use App\Tenant\Conversation;
use Illuminate\Database\Eloquent\Model;

class RemovedConversation extends Model
{
    protected $fillable = ['website_id', 'conversation_id'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
