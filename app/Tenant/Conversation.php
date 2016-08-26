<?php

namespace App\Tenant;

use App\ActiveConversation;
use App\FlaggedConversation;
use App\Note;
use App\ReturningConversation;
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

    protected $appends = [
        'is_flagged', 'is_active',
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

    public function last_message()
    {
        return $this->hasOne(LastMessage::class, 'conversationId');
    }

    public function returning_conversation()
    {
        return $this->hasOne(ReturningConversation::class, 'conversation_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'conversation_id');
    }

    public function flagged()
    {
        return $this->hasOne(FlaggedConversation::class);
    }

    public function active()
    {
        return $this->hasOne(ActiveConversation::class);
    }

    public function getIsFlaggedAttribute()
    {
        return !is_null($this->flagged);
    }

    public function getIsActiveAttribute()
    {
        return !is_null($this->active);
    }

}
