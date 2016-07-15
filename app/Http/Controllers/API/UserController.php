<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('websites')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->password = bcrypt($request->password);
        $user = User::create($request->all());
        $users = User::where('id', $user->id)->with('websites')->first();
        return response()->json($users);
    }

    public function delete(Request $request)
    {
        User::destroy($request->users);
        return response()->json('Deleted!', 200);
    }
}
