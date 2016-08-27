<?php

namespace App\Http\Controllers;

use App\Tenant\User;
use App\Website;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with('ftp')->get();
        return view('websites.index', compact('websites'));
    }

    public function show(Website $website)
    {
        return view('websites.manage')->with(compact('website'));
    }

    public function users(Website $website)
    {
        try {
            $users = User::with('avatar', 'profile')->paginate(10)->toJson();
        } catch (\QueryException $ex) {
            abort(404);
        }

        return view('websites.users')->with(compact('website', 'users'));
    }
}
