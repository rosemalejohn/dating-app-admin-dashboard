<?php

namespace App\Http\Controllers;

use App\Tenant\User as TenantUser;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit(Request $request, $id)
    {
        $user = User::whereId($id)->with('managed_websites')->first();

        if ($request->user()->can('edit-user', $user)) {
            return view('users.edit')->with(compact('user'));
        }
        abort(403);
    }

    public function getExternalUsers()
    {
        $users = TenantUser::with('avatar', 'profile')->get();
        return view('external-users.index')->with(compact('users'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('users.edit')->with(compact('user'));
    }
}
