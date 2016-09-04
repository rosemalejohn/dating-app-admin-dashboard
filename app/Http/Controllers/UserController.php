<?php

namespace App\Http\Controllers;

use App\Tenant\User as TenantUser;
use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_super) {
            $users = User::all();
        } elseif (auth()->user()->is_admin) {
            $users = User::whereType('admin')->orWhere('type', 'moderator')->get();
        }
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

    public function getAccount(User $user)
    {
        if (auth()->user()->is_super or auth()->user()->is_admin or ($user->id == auth()->user()->id)) {
            return view('users.account')->with(compact('user'));
        }
        abort(403);
    }

}
