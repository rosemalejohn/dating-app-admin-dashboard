<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model;

class OnlineUser extends Model
{
    protected $connection = 'tenant';

    protected $table = 'base_user_online';

    public $timestamps = false;

    protected $fillable = ['userId', 'activityStamp', 'context'];

}
