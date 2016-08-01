<?php

namespace App\Tenant;

use App\Tenant\Model;
use App\Website;

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

    public function website()
    {
        return $this->belongsToMany(Website::class, 'website_users', 'userId', 'website_id');
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

    public function messages($query)
    {
        // return $query->with(['messages' => function ($q) {
        //     $q->where('senderId', $this->id)->orWhere('recipientId', $this->id);
        // }]);
    }
}
