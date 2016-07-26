<?php

namespace App\Http\Controllers\API;

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
        ];

        $this->validate($request, $this->validator());

        $user = User::create($data);

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

    protected function getPhoto($photo)
    {
        $data = get_base64_string($photo);
        if ($data) {
            $image = \Image::make($data);
            $filename = '/uploads/img/' . str_random(16) . '.jpg';
            $image->fit(500, 500)->save(public_path($filename));
            return $filename;
        }
        return null;
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
