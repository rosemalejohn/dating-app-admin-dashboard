<?php

namespace App\Tenant;

use App\Tenant\Model;

class Guest extends Model
{
    protected $table = 'ocsguests_guest';

    protected $fillable = ['userId', 'guestId', 'viewed', 'visitTimestamp'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function guest()
    {
        return $this->belongsTo(User::class, 'guestId');
    }

}
