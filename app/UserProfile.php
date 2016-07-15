<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo', 'contact_number', 'address', 'intro_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
