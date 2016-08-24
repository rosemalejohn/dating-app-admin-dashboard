<?php

namespace App;

use App\Tenant\Conversation;
use Illuminate\Database\Eloquent\Model;

class ReturningConversation extends Model
{
    protected $fillable = ['website_id', 'conversation_id', 'status'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function scopeLastTwentyFourHours($query)
    {
        return $query->whereStatus(1);
    }

    public function scopeLastThreeDays($query)
    {
        return $query->whereStatus(2);
    }

    public function scopeLastTwoWeeks($query)
    {
        return $query->whereStatus(3);
    }
}
