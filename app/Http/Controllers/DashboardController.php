<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use App\Website;

class DashboardController extends Controller
{
    public function index(MessageService $msgService)
    {
        $conversations = count($msgService->getConversations());

        $websites = Website::all();

        return view('dashboard.index')->with(compact('conversations', 'websites'));
    }
}
