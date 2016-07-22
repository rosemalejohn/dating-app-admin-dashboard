<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $connection = 'tenant';

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
        'read' => 'boolean',
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

}
