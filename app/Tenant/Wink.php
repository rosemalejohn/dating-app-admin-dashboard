<?php

namespace App\Tenant;

use App\Tenant\Model;

class Wink extends Model
{
    protected $table = 'winks_winks';

    protected $fillable = ['userId', 'partnerId', 'timestamp', 'status', 'viewed', 'conversationId', 'winkback', 'messageType'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partnerId');
    }

}
