<?php

namespace App\Http\Controllers;

use App\Services\MessageService;

class DashboardController extends Controller
{
    public function index(MessageService $msgService)
    {
        $conversations = count($msgService->getConversations());

        return view('dashboard.index')->with(compact('conversations'));
    }
}
