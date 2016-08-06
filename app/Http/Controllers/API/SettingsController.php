<?php

namespace App\Http\Controllers\API;

use App\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $resultSet = Config::all();

        $configs = $resultSet->groupBy(function ($config) {
            return $config->key;
        })->transform(function ($item) {
            return $item->first();
        })->toArray();

        return response()->json($configs);
    }

    public function update(Request $request)
    {
        $configs = $request->all();

        foreach ($configs as $config) {
            Config::whereId($config['id'])->update($config);
        }

        return response()->json('Settings updated!');
    }
}
