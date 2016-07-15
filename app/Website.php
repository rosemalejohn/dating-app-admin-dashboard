<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'logo', 'url', 'db_url', 'db_name', 'db_user', 'db_pass', 'db_prefix',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_websites');
    }
}
