<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $connection = 'tenant';

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

    public function getIsSenderAttribute()
    {

    }

    public function getIsRecipientAttribute()
    {

    }

}
