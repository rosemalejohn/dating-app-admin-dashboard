<?php

namespace App\Tenant;

use App\Tenant\Model;

class Conversation extends Model
{

    protected $table = 'mailbox_conversation';

    protected $fillable = [
        'initiatorId',
        'interlocutorId',
        'subject',
        'read',
        'deleted',
        'viewed',
        'notificationSent',
        'createStamp',
        'initiatorDeletedStamp',
        'interlocutorDeletedTimestamp',
        'lastMessageId',
        'lastMessageTimestamp',
    ];

    public $timestamps = false;

    protected $casts = [
        'deleted' => 'boolean',
        'viewed' => 'boolean',
        'notificationSent' => 'boolean',
    ];

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiatorId');
    }

    public function interlocutor()
    {
        return $this->belongsTo(User::class, 'interlocutorId');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversationId');
    }

    public function scopeMailbox($query)
    {
        return $query->whereSubject('mailbox_chat_conversation');
    }

    public function last_message()
    {
        return $this->hasOne(LastMessage::class, 'conversationId');
    }

}
