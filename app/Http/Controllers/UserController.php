<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->with('profile')->first();
        return view('users.edit')->with(compact('user'));
    }
}
