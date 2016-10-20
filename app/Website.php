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
        return $this->hasMany(\App\Tenant\User::class);
    }

    public function managed_users()
    {
        return $this->hasMany(WebsiteUser::class);
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'user_managed_websites')->withTimestamps();
    }

    public function ftp()
    {
        return $this->hasOne(WebsiteFTP::class);
    }
}
