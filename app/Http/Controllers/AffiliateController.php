<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AffiliateController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:affiliate');
	}

	public function index()
	{
		return view('affiliates.home');
	}
}
