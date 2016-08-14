<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\TenantService;
use App\Tenant\Message;
use App\User;
use App\UserSentMessageReply;
use App\Website;
use Carbon\Carbon;

class StatController extends Controller
{

    public $tenant;

    public function __construct(TenantService $tenant)
    {
        $this->tenant = $tenant;
    }

    public function getStats()
    {
        return response()->json([
            [
                'name' => 'Websites',
                'icon' => 'fa fa-globe',
                'count' => Website::all()->count(),
                'color' => 'blue',
                'link' => '/websites',
            ],
            [
                'name' => 'Users',
                'icon' => 'fa fa-users',
                'count' => User::all()->count(),
                'color' => 'red',
                'link' => '/users',
            ],
            [
                'name' => 'Messages',
                'icon' => 'fa fa-comment-o',
                'count' => $this->getTotalMessages(),
                'color' => 'green',
                'link' => '/chat',
            ],
            [
                'name' => 'Current payouts',
                'icon' => 'fa fa-usd',
                'count' => $this->getCurrentPayouts() . auth()->user()->currency,
                'color' => 'purple',
                'link' => '/users',
            ],
        ]);
    }

    public function getMessagesPerDay(Website $website)
    {
        $date = Carbon::createFromDate('2015');

        $messages = Message::select('timeStamp')
            ->whereBetween('timeStamp', [$date->startOfYear()->timestamp, $date->endOfYear()->timestamp])
            ->get()
            ->groupBy(function ($message) {
                return Carbon::createFromTimestamp($message->timeStamp)->format('M-d-Y');
            });

        return response()->json($messages);
    }

    public function getTotalMessages()
    {
        $date = \Carbon\Carbon::now()->startOfYear()->timestamp;

        $websites = \App\Website::all();

        $messages = collect();

        foreach ($websites as $website) {

            $this->tenant->connect($website);

            $managed_users = $website->managed_users()->with('user.conversation_interlocutors.messages')->get();

            $mapped = $managed_users->map(function ($item, $key) use ($date) {
                return $item->user->conversation_interlocutors->map(function ($item, $key) use ($date) {
                    return $item->messages()
                        ->where('timeStamp', '>=', $date)->get();
                });
            });

            $messages->push($mapped->flatten());

        }

        return $messages->flatten()->count();
    }

    protected function getTotalEarnings()
    {
        $earnings = 0;

        $replies = UserSentMessageReply::with(['user_message.user' => function ($query) {
            $query->select('id', 'pay_rate');
        }])->get();

        foreach ($replies as $reply) {
            $earnings = $earnings + $reply->user_message->user->pay_rate;
        }

        return $earnings;

    }

    protected function getCurrentPayouts()
    {
        $earnings = 0;

        $replies = UserSentMessageReply::unpaid()->with('user_message.user')->get();

        foreach ($replies as $reply) {
            $earnings = $earnings + $reply->user_message->user->pay_rate;
        }

        return $earnings;
    }
}
