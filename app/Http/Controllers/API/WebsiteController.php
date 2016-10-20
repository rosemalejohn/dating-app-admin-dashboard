<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\TenantService;
use App\Tenant\User;
use App\Website;
use App\WebsiteUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with('ftp')->get();

        return response()->json($websites);
    }

    public function users(Request $request, Website $website)
    {
        $users = $website->managed_users()->with(['user' => function ($query) {
            $query->with('avatar', 'profile');
        }])->paginate(15);

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

        return response()->json($managedUser, 200);
    }

    public function store(Request $request, TenantService $tenant)
    {

        $this->validate($request, $this->validator($request->all()));

        $website = new Website;
        $website->database = $request->database;
        $website->host = $request->host;
        $website->name = $request->name;
        $website->password = $request->password;
        $website->port = $request->port;
        $website->prefix = $request->prefix;
        $website->url = rtrim($request->url, '/');
        $website->username = $request->username;

        if (auth()->user()->can('store', $website)) {
            if ($tenant->testConnection($website)) {
                $website->save();
                $website->ftp()->create($request->ftp);
                return response()->json($website, 201);
            }
            return response()->json('We cannot connect to the database, please check the connection again.', 500);
        }
        return response()->json('Not saved! You have exceeded the maximum allowed website.', 500);
    }

    public function update(Request $request, Website $website)
    {
        $request->url = rtrim($request->url, '/');
        if ($website->ftp) {
            $website->ftp->update($request->ftp);
        } else {
            $website->ftp()->create($request->ftp);
        }
        $website->update($this->getWebsite($request));

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

    public function bulkAddUsers(Request $request, Website $website)
    {
        $date_from = new Carbon($request->date_from);
        $date_to = new Carbon($request->date_to);

        $users = User::whereBetween('joinStamp', [$date_from->timestamp, $date_to->timestamp])
            ->with('avatar', 'profile')
            ->get();

        foreach ($users as $user) {
            try {
                $website->managed_users()->create([
                    'userId' => $user->id,
                ]);
            } catch (\Illuminate\Database\QueryException $ex) {

            }
        }

        return response()->json($users, 200);
    }

    protected function getWebsite($request)
    {
        return [
            'name' => $request->name,
            'logo' => $request->logo,
            'url' => rtrim($request->url, '/'),
            'host' => $request->host,
            'database' => $request->database,
            'username' => $request->username,
            'password' => $request->password,
            'prefix' => $request->prefix,
        ];
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
