<?php

namespace App\Console\Commands;

use App\UserSentMessage;
use Illuminate\Console\Command;
use App\ReturningConversation;
use Carbon\Carbon;

class ReturningConversation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversation:return-lobby';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return conversation to lobby';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $last_twenty_four = UserSentMessage::lastTwentyFourHours()->get();
        $last_three_days = UserSentMessage::lastThreeDays()->get();
        $last_two_weeks = UserSentMessage::lastTwoWeeks()->get();

        foreach ($last_twenty_four as $sent_message) {
            ReturningConversation::create([
                'website_id' => $sent_message->website_id,
                'conversation' => $sent_message->message->conversationId,
            ]);
        }

        foreach ($last_three_days as $sent_message) {
            $returning_conversation = $sent_message->conversation->returning_conversation;
            if (returning_conversation) {
                $returning_conversation->update(['status' => 2]); 
            }
        }

        foreach ($last_two_weeks as $sent_message) {
            $returning_conversation = $sent_message->conversation->returning_conversation;
            if ($returning_conversation) {
                $returning_conversation->update(['status' => 3]);
            }
        }

        $returning_conversations = ReturningConversation::all();
    }
}
