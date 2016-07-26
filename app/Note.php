<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

    protected $fillable = ['website_id', 'conversation_id', 'note', 'type'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function scopeInterlocutor($query)
    {
        return $query->whereType('interlocutor');
    }

    public function scopeInitiator($query)
    {
        return $query->whereType('initiator');
    }

}
