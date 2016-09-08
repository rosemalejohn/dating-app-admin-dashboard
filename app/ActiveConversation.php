<?php

namespace App;

use App\Tenant\Conversation;
use Illuminate\Database\Eloquent\Model;

class ActiveConversation extends Model
{
    protected $fillable = ['website_id', 'conversation_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
