<?php

namespace App\Console\Commands;

use App\Config;
use App\ProfileSentMessage;
use App\Services\TenantService;
use App\Tenant\Conversation;
use App\Tenant\Guest;
use App\Tenant\Message;
use App\Tenant\User;
use App\Tenant\Wink;
use App\Website;
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

        if ($allow_intro_message_sent_to_male_members->value == 1) {

            $count = Config::whereKey('number_of_messages_per_cron_job')->first()->value;

            $websites = Website::all();

            $collection = collect();

            foreach ($websites as $website) {

                echo "Getting data in website: {$website->name}\n";

                $tenant->connect($website);

                $dateAgo = Carbon::now()->subYears(3);

                $users = User::where('joinStamp', '>=', $dateAgo)->take($count)->males();

                $managed_users = $website->managed_users;

                foreach ($managed_users as $managed) {
                    $managed_user = $managed->user;

                    foreach ($users as $user) {
                        $profile_sent_message = ProfileSentMessage::where('website_id', $website->id)
                            ->where('profile_id', $managed_user->id)
                            ->where('recipient_id', $user->id)->first();
                        if (is_null($profile_sent_message) && trim($managed->fake_message)) {
                            $conversation = Conversation::create([
                                'initiatorId' => $managed_user->id,
                                'interlocutorId' => $user->id,
                                'subject' => '',
                                'createStamp' => time(),
                            ]);

                            $message = new Message;
                            $message->timeStamp = time();
                            $message->senderId = $managed_user->id;
                            $message->recipientId = $user->id;
                            $message->text = $managed->fake_message;

                            $conversation->messages()->save($message);

                            $guest = Guest::where('userId', $user->id)->where('guestId', $managed_user->id)->first();

                            $wink = Wink::where('userId', $managed_user->id)->where('partnerId', $user->id)->first();

                            if ($guest) {
                                $guest->update(['visitTimestamp' => time()]);
                            } else {
                                $managed_user->guests()->create(['visitTimestamp' => time(), 'userId' => $user->id]);
                            }

                            if ($wink) {
                                $wink->update(['timestamp' => time()]);
                            } else {
                                $managed_user->wink_users()->create(['partnerId' => $user->id, 'messageType' => 'mail', 'status' => 'wait']);
                            }

                            ProfileSentMessage::create([
                                'website_id' => $website->id,
                                'profile_id' => $managed_user->id,
                                'recipient_id' => $user->id,
                            ]);

                            echo 'Message sent!';
                        }
                    }
                }

            }
        }

    }
}
