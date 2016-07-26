<?php

namespace App\Tenant;

use App\Tenant\Model;

class Message extends Model
{

    protected $table = 'mailbox_message';

    protected $casts = [
        'recipientRead' => 'boolean',
    ];

    public $timestamps = false;

    protected $appends = ['is_sender', 'is_recipient'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversationId');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'senderId');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipientId');
    }

    public function scopeUnread($query)
    {
        return $query->where('recipientRead', 0);
    }

    public function getIsSenderAttribute()
    {
        if ($this->sender && $this->conversation->initiator) {
            return $this->sender->id == $this->conversation->initiator->id;
        }
    }

    public function getIsRecipientAttribute()
    {
        if ($this->sender && $this->conversation->interlocutor) {
            return $this->recipient->id == $this->conversation->interlocutor->id;
        }
    }

}
