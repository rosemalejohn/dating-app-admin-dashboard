<?php

namespace App\Tenant;

use App\Tenant\Model;

class LastMessage extends Model
{

    protected $table = 'mailbox_last_message';

    protected $fillable = ['conversationId', 'initiatorMessageId', 'interlocutorMessageId'];

    public $timestamps = false;

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversationId');
    }

    public function initiator()
    {
        return $this->belongsTo(Message::class, 'initiatorMessageId');
    }

    public function interlocutor()
    {
        return $this->belongsTo(Message::class, 'interlocutorMessageId');
    }
}
