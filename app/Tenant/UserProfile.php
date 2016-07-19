<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

    protected $connection = 'tenant';

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
    protected $appends = ['address'];

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

}
