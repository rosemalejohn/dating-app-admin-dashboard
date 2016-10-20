<?php

namespace App\Affiliate;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'birthday',
        'address',
        'country',
        'phone',
        'skype',
        'payment',
        'currency',
        'email',
        'password',
        'qr_code',
        'photo',
        'company',
        'upline_id',
        'upline_type',
    ];

    protected $table = 'affiliates';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function contract()
    {
        return $this->hasOne(ContractTerm::class, 'affiliate_id');
    }

    public function domains()
    {
        return $this->hasMany(Domain::class, 'affiliate_id');
    }

    public function uplineable()
    {
        return $this->morphTo();
    }

    public function upline()
    {
        return $this->morph(User::class, 'uplineable');
    }

}
