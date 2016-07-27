<?php

namespace App\Tenant;

use App\Tenant\Model;

class UserProfile extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'base_question_data';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['address', 'real_name', 'about_me', 'sex', 'looking_for'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAddressAttribute()
    {
        $address = UserProfile::where('userId', $this->id)->where('questionName', 'googlemap_location')->first();
        if ($address) {
            return $address->textValue;
        }
    }

    public function getRealNameAttribute()
    {
        $name = UserProfile::where('userId', $this->id)->where('questionName', 'realname')->first();
        if ($name) {
            return $name->textValue;
        }
    }

    public function getAboutMeAttribute()
    {
        $about = UserProfile::where('userId', $this->id)->where('questionName', 'aboutme')->first();
        return $about ? $about->textValue : null;
    }

    public function getSexAttribute()
    {
        $sex = UserProfile::where('userId', $this->id)->where('questionName', 'sex')->first();
        return 'male';
    }

    public function getLookingForAttribute()
    {
        return 'Male';
    }

}
