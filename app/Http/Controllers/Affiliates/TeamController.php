<?php

namespace App\Http\Controllers\Affiliates;

use App\Affiliate\User;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index()
    {
        $affiliates = User::with('domains')->get();
        return view('affiliates.teams')->with(compact('affiliates'));
    }
}
