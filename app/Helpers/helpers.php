<?php

if (!function_exists('convert_base64')) {

    function get_base64_string($base64_string)
    {
        $data = explode(',', $base64_string);
        if (isset($data[1])) {
            return $data[1];
        }
        return null;
    }

}

if (!function_exists('connectToTenant')) {

    function connectToTenant($website)
    {
        config([
            'database.connections.tenant.url' => $website->url,
            'database.connections.tenant.host' => $website->host,
            'database.connections.tenant.port' => $website->port,
            'database.connections.tenant.database' => $website->database,
            'database.connections.tenant.username' => $website->username,
            'database.connections.tenant.password' => $website->password,
            'database.connections.tenant.prefix' => $website->prefix,
        ]);
    }

}
