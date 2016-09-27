<?php

namespace App\Http\Controllers\Affiliates;

use App\Affiliates\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $affiliates = User::all();
        return view('affiliates.users')->with(compact('affiliates'));
    }

    public function create()
    {
        return view('affiliates.create');
    }
}
