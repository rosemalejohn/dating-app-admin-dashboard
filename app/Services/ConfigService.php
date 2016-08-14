<?php namespace App\Services;

use App\Config;

class ConfigService
{

    public function getConfigValue($key)
    {
        return $this->getConfig($key)->value;
    }

    public function getConfig($key)
    {
        return Config::whereKey($key)->first();
    }

}
