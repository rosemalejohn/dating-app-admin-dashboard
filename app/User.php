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
        'name', 'email', 'password', 'type', 'contact_info', 'photo', 'currency', 'pay_rate',
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
    protected $appends = ['is_admin', 'is_super', 'is_mine', 'is_moderator'];

    public function getIsAdminAttribute()
    {
        return $this->type == 'admin';
    }

    public function getIsSuperAttribute()
    {
        return $this->type == 'super';
    }

    public function getIsModeratorAttribute()
    {
        return $this->type == 'moderator';
    }

    public function getIsMineAttribute()
    {
        return $this->id == auth()->user()->id;
    }

    public function managed_websites()
    {
        return $this->belongsToMany(Website::class, 'user_managed_websites')->withTimestamps();
    }

    public function sent_messages()
    {
        return $this->hasMany(UserSentMessage::class);
    }
}
