<?php

namespace App\Console\Commands;

use App\Config;
use App\Conversation;
use App\Services\TenantService;
use App\Tenant\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomly send fake message';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(TenantService $tenant)
    {
        $allow_intro_message_sent_to_male_members = Config::whereKey('allow_intro_message_sent_to_male_members')->first();

        if ($allow_intro_message_sent_to_male_members) {

            $count = Config::whereKey('number_of_messages_per_cron_job')->first();

            $websites = Website::all();

            $collection = collect();

            foreach ($websites as $website) {

                $tenant->connect($website);

                $dateAgo = Carbon::now()->subDays(15);

                $users = User::where('joinStamp', '>=', $dateAgo)->take($count)->get();

                $managed_users = $website->managed_users;

                foreach ($managed_users as $managed) {
                    $managed_user = $managed->user;

                    foreach ($users as $user) {
                        $conversation = Conversation::create([
                            'initiatorId' => $managed_user->id,
                            'interlocutorId' => $user->id,
                            'subject' => '',
                            'createStamp' => date(),
                        ]);

                        $message = new Message;
                        $message->timeStamp = time();
                        $message->senderId = $managed_user->id;
                        $message->recipientId = $user->id;
                        $message->text = $managed->fake_messages;

                        $conversation->messages()->save($message);
                    }
                }
            }
        }

    }
}
