<?php

namespace App\Tenant;

use App\Tenant\Model;

class User extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'base_user';

    public $timestamps = false;

    public function avatar()
    {
        return $this->hasOne(UserPhoto::class, 'userId');
    }

    public function profile()
    {
        return $this->hasMany(UserProfile::class, 'userId');
    }

    public function websiteUser()
    {
        return $this->hasOne(\App\WebsiteUser::class);
    }

    public function online()
    {
        return $this->hasOne(OnlineUser::class, 'userId');
    }

    public function conversation_initiators()
    {
        return $this->hasMany(Conversation::class, 'initiatorId');
    }

    public function conversation_interlocutors()
    {
        return $this->hasMany(Conversation::class, 'interlocutorId');
    }
}
