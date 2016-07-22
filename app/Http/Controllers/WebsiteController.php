<?php

namespace App\Http\Controllers;

use App\Tenant\User;
use App\Website;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();
        return view('websites.index', compact('websites'));
    }

    public function show(Website $website)
    {

        return view('websites.manage')->with(compact('website'));
    }

    public function users(Website $website)
    {
        $users = User::with('avatar', 'profile')->paginate(10)->toJson();

        return view('websites.users')->with(compact('website', 'users'));
    }
}
