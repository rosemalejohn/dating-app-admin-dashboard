<?php namespace App\Services;

use App\Website;
use Config;
use DB;

class TenantService
{

    public function testConnection(Website $website)
    {
        $this->connect($website);

        try {
            $pdo = DB::connection('tenant')->getPdo();
            return true;
        } catch (\PDOException $ex) {
            return false;
        } catch (\ErrorException $ex) {
            return false;
        }
    }

    public function connect(Website $website)
    {
        DB::purge('tenant');
        config([
            'database.connections.tenant.url' => $website->url,
            'database.connections.tenant.host' => $website->host,
            'database.connections.tenant.port' => $website->port,
            'database.connections.tenant.database' => $website->database,
            'database.connections.tenant.username' => $website->username,
            'database.connections.tenant.password' => $website->password,
            'database.connections.tenant.prefix' => $website->prefix,
        ]);

        return true;
    }

    public function getConnection()
    {
        return Config::get('database.connections.tenant');
    }

}
