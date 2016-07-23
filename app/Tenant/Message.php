<?php

namespace App\Tenant;

use App\Tenant\Model;

class Message extends Model
{

    protected $table = 'mailbox_message';

    protected $fillable = [
        'conversationId',
        'timeStamp',
        'senderId',
        'recipientId',
        'text',
    ];

    public $timestamps = false;

    protected $appends = ['is_sender', 'is_recipient'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
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

    }

    public function getIsRecipientAttribute()
    {

    }

}
