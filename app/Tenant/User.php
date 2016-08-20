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

    protected $dates = ['joinStamp'];

    protected $appends = ['real_name', 'about_me', 'address', 'sex'];

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

    public function guest_users()
    {
        return $this->hasMany(Guest::class, 'userId');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class, 'guestId');
    }

    public function wink_users()
    {
        return $this->hasMany(Wink::class, 'userId');
    }

    public function wink_partners()
    {
        return $this->hasMany(Wink::class, 'partnerId');
    }

    public function getAddressAttribute()
    {
        $address = $this->profile()->where('userId', $this->id)->where('questionName', 'googlemap_location')->first();

        return $address ? $address->textValue : null;
    }

    public function getRealNameAttribute()
    {
        $name = $this->profile()->where('userId', $this->id)->where('questionName', 'realname')->first();
        return $name ? $name->textValue : null;
    }

    public function getAboutMeAttribute()
    {
        $about_me = $this->profile()->where('userId', $this->id)->where('questionName', 'aboutme')->first();
        return $about_me ? $about_me->textValue : null;
    }

    public function getSexAttribute()
    {
        $sex = $this->profile()->where('userId', $this->id)->where('questionName', 'sex')->first();
        if ($sex) {
            switch ($sex->intValue) {
                case 2:
                    return 'female';
                    break;
                case 4:
                    return 'male';
                    break;
                default:
                    return null;
                    break;
            }
        }
        return null;
    }

    public function scopeMales($query)
    {
        return $query->get()->filter(function ($user) {
            return $user->sex == 'male';
        });
    }
}
