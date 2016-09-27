<?php

namespace App\Affiliate;

use App\Website;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    protected $fillable = ['domain_id', 'affiliate_id'];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function website()
    {
        return $this->belongsTo(Website::class, 'domain_id');
    }

}
