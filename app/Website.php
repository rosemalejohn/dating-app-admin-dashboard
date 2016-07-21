<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'logo', 'url', 'host', 'database', 'username', 'password', 'prefix', 'port',
    ];

    public function users()
    {
        return $this->belongsToMany(Tenant\User::class, 'user_websites');
    }

    public function managed_users()
    {
        return $this->hasMany(WebsiteUser::class);
    }

}
