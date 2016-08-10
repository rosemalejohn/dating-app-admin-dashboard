<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSentMessageReply extends Model
{
    protected $fillable = ['message_id', 'user_sent_message_id'];

    public function user_message()
    {
        return $this->belongsTo(UserSentMessage::class, 'user_sent_message_id');
    }
}
