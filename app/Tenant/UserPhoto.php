<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{

    protected $connection = 'tenant';

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'base_avatar';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        return config('database.connections.tenant.url') . '/ow_userfiles/plugins/base/avatars/avatar_big_' . $this->userId . '_' . $this->hash . '.jpg';
    }

}
