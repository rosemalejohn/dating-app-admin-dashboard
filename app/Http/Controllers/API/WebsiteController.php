<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tenant\User;
use App\Website;
use App\WebsiteUser;
use Illuminate\Http\Request;
use Image;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();

        return response()->json($websites);
    }

    public function users(Request $request, Website $website)
    {
        $users = $website->managed_users()->with(['user' => function ($query) {
            $query->with('avatar', 'profile');
        }])->paginate(5);

        return response()->json($users, 200);
    }

    public function searchUsers(Website $website, $search)
    {
        $users = User::with('avatar', 'profile')
            ->where('username', 'like', "%{$search}%")
            ->paginate(10);
        return response()->json($users, 200);
    }

    public function storeManagedUsers(Website $website, Request $request)
    {
        $managedUser = $website->managed_users()->create([
            'userId' => $request->userId,
            'fake_message' => $request->fake_message,
        ]);

        dd($managedUser);

        return response()->json($managedUser, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validator($request->all()));

        $website = Website::create($this->getWebsite($request));
        return response()->json($website, 201);
    }

    public function update(Request $request, Website $website)
    {
        $website->update($request->all());
        return response()->json(true);
    }

    public function delete(Website $website)
    {
        $website->delete();
        return response()->json('Website deleted!');
    }

    public function unmanageUsers(Request $request, Website $website)
    {
        WebsiteUser::destroy($request->users);

        return response()->json('Successfully removed managed users.', 200);
    }

    public function changePhoto(Request $request, Website $website)
    {
        $website->logo = $request->logo;
        $website->save();
        return response()->json('Photo saved!');
    }

    public function updateManagedUser(Request $request, Website $website, $id)
    {
        $website->managed_users()->whereId($id)->update([
            'fake_message' => $request->fake_message,
        ]);

        return response()->json('User updated!', 200);
    }

    protected function getWebsite($request)
    {
        return [
            'name' => $request->name,
            'logo' => $request->logo ? $this->getImage($request->logo) : null,
            'url' => $request->url,
            'host' => $request->host,
            'database' => $request->database,
            'username' => $request->username,
            'password' => $request->password,
            'prefix' => $request->prefix,
        ];
    }

    protected function getImage($image)
    {
        $data = get_base64_string($image);
        if ($data) {
            $image = Image::make($data);
            $filename = '/uploads/img/' . str_random(16) . '.jpg';
            $image->fit(500, 500)->save(public_path($filename));
            return $filename;
        }
        return null;
    }

    protected function validator()
    {
        return [
            'name' => 'required',
            'url' => 'required',
            'host' => 'required',
            'database' => 'required',
            'username' => 'required',
        ];
    }
}
