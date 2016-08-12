<?php

namespace App;

use App\Tenant\User;
use Illuminate\Database\Eloquent\Model;

class ProfileSentMessage extends Model
{
    protected $fillable = ['website_id', 'profile_id', 'recipient_id'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function moderated_profile()
    {
        return $this->belongsTo(User::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class);
    }
}
