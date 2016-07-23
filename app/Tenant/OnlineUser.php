<?php

namespace App\Tenant;

use App\Tenant\Model;

class OnlineUser extends Model
{

    protected $table = 'base_user_online';

    public $timestamps = false;

    protected $fillable = ['userId', 'activityStamp', 'context'];

}
