<?php

namespace App\Http\Controllers\API;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'contact_info' => $request->contact_info,
            'type' => $request->type,
            'pay_rate' => $request->pay_rate,
        ];

        $this->validate($request, $this->validator());

        $user = User::create($data);

        event(new UserCreated($user));

        $user->managed_websites()->sync($request->websites);

        return response()->json($user);
    }

    public function update(Request $request, $user)
    {
        // if ($request->user()->can('edit-user', $user)) {

        $user = User::findOrFail($user);

        $this->validate($request, [
            'name' => 'required|max:255|min:1',
            'email' => 'required',
        ]);

        $user->managed_websites()->sync($request->websites);

        $user->update($request->all());

        // }
        // abort(403);
    }

    public function delete(Request $request)
    {
        User::destroy($request->users);
        return response()->json('Successfully deleted ' . count($request->users) . ' users.', 200);
    }

    public function updateAccount(Request $request, User $user)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
            'old_password' => "validate_auth:{$user->id}",
        ]);

        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json('Account updated.', 201);
    }

    public function clearEarnings(User $user)
    {
        $sent = $user->sent_messages()->has('replies')->get();
        foreach ($sent as $message) {
            $message->replies()->unpaid()->get()->each(function ($reply) {
                $reply->paid = true;
                $reply->save();
            });
        }
        return response()->json('User earnings cleared.', 200);
    }

    public function validator()
    {
        return [
            'name' => 'required|max:255|min:1',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ];
    }
}
