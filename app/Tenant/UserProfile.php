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

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

}
