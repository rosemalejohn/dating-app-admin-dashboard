<?php namespace App\Tenant;

use App\Tenant\Website;
use Illuminate\Database\Eloquent\Model;

class TenantModel extends Model
{

    public function __construct(Website $website)
    {
        connectToTenant($website);
    }

}
