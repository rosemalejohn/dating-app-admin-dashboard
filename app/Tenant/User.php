<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $connection = 'tenant';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'base_user';

    public function avatar()
    {
        return $this->hasOne(UserPhoto::class, 'userId');
    }

    public function profile()
    {
        return $this->hasMany(UserProfile::class, 'userId');
    }

}
