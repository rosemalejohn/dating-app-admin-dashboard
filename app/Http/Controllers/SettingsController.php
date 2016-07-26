<?php

namespace App\Http\Controllers;

use App\Config;

class SettingsController extends Controller
{
    public function system()
    {
        $configs = Config::all();
        return view('settings.system')->with(compact('configs'));
    }
}
