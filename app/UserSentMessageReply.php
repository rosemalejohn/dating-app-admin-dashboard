<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSentMessageReply extends Model
{
    protected $fillable = ['message_id', 'user_sent_message_id', 'paid'];

    public function user_message()
    {
        return $this->belongsTo(UserSentMessage::class, 'user_sent_message_id');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('paid', 0);
    }

    public function scopePaid($query)
    {
        return $query->where('paid', 1);
    }
}
