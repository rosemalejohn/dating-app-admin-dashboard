<?php

namespace App;

use App\Tenant\Message;
use Carbon\Carbon;
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

    public function scopeLastTwentyFourHours($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->subDay()->startOfDay(),
            Carbon::now()->subDay()->endOfDay(),
        ])->whereDoesntHave('replies')->orderBy('created_at', 'desc');
    }

    public function scopeLastThreeDays($query)
    {
        return $query
            ->whereBetween('created_at', [Carbon::now()->subDays(3)->startOfDay(), Carbon::now()->subDays(3)->endOfDay()])
            ->whereDoesntHave('replies');
    }

    public function scopeLastTwoWeeks($query)
    {
        return $query
            ->whereBetween('created_at', [Carbon::now()->subWeeks(2)->startOfDay(), Carbon::now()->subWeeks(2)->endOfDay()])
            ->whereDoesntHave('replies');
    }

}
