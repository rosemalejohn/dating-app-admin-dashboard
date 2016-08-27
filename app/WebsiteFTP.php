<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteFTP extends Model
{
    protected $fillable = ['host', 'username', 'password'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
