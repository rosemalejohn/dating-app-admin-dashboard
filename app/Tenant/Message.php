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

    public function scopeInitiatorMessages($query)
    {
        $conversation = $query->getModel()->with('conversation')->first();
        return $query->where('senderId', $conversation->initiator->id);
    }

    public function getIsSenderAttribute()
    {
        if ($this->sender && $this->conversation && $this->conversation->initiator) {
            return $this->senderId == $this->conversation->initiator->id;
        }
    }

    public function getIsRecipientAttribute()
    {
        if ($this->sender && $this->conversation && $this->conversation->interlocutor) {
            return $this->recipientId == $this->conversation->interlocutor->id;
        }
    }

    public function getIsLastAttribute()
    {
        $last = $this->conversation->messages->last();
        if ($last && ($last->id == $this->id)) {
            return true;
        }
    }

}
