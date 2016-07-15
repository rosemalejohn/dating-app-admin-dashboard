<?php

namespace App\Http\Controllers;

use App\Website;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with('users')->get();
        return view('websites.index', compact('websites'));
    }
}
