<?php

namespace App;

use App\Tenant\Message;
use Illuminate\Database\Eloquent\Model;

class UserSentMessage extends Model
{

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

}
