<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{

    protected $connection = 'tenant';

    public function __construct()
    {
        // $this->setConnection('tenant');
    }

}
