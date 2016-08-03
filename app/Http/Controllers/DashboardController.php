<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use App\Website;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, MessageService $msgService)
    {

        if (!auth()->check()) {
            return view('auth.login');
        }

        if ($request->user()->is_moderator) {
            return redirect()->to('/chat');
        }

        $conversations = count($msgService->getConversations());

        $websites = Website::all();

        return view('dashboard.index')->with(compact('conversations', 'websites'));
    }
}
