<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_admin', 'is_mine'];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function websites()
    {
        return $this->belongsToMany(Website::class, 'user_websites');
    }

    public function isMine()
    {
        return $this->id == auth()->user()->id;
    }

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function getIsMineAttribute()
    {
        return $this->isMine();
    }
}
