<?php

namespace App\Affiliate;

use Illuminate\Database\Eloquent\Model;

class ContractTerm extends Model
{

    protected $table = 'affiliate_contract_terms';

    protected $fillable = [
        'chargeback_rate',
        'minimum_payout',
        'chargeback_fee',
        'billing_period',
        'rolling_reserve',
        'rolling_reserve_period',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
