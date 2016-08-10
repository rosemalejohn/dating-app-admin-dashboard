<?php

namespace App;

use App\Tenant\Message;
use Illuminate\Database\Eloquent\Model;

class UserSentMessage extends Model
{

    protected $fillable = ['user_id', 'website_id', 'message_id', 'replies'];

    protected $casts = [
        'computed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function replies()
    {
        return $this->hasMany(UserSentMessageReply::class);
    }

}
