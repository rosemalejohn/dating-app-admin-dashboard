<?php

namespace App\Console\Commands;

use App\ReturningConversation as ReturningConversationModel;
use App\Services\TenantService;
use App\UserSentMessage;
use App\Website;
use Illuminate\Console\Command;

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
    public $tenant;

    public function __construct(TenantService $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
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
            $website = Website::find($sent_message->website_id);
            $this->tenant->connect($website);
            try {
                ReturningConversationModel::create([
                    'website_id' => $sent_message->website_id,
                    'conversation_id' => $sent_message->message->conversationId,
                ]);
            } catch (\Illuminate\Database\QueryException $ex) {}

        }

        foreach ($last_three_days as $sent_message) {
            $this->updateReturningConversation($sent_message, ['status' => 2, 'already_sent' => false]);
        }

        foreach ($last_two_weeks as $sent_message) {
            $this->updateReturningConversation($sent_message, ['status' => 3, 'already_sent' => false]);
        }
    }

    protected function updateReturningConversation($sent_message, $data)
    {
        $website = Website::find($sent_message->website_id);
        $this->tenant->connect($website);
        $returning_conversation = $sent_message->message->conversation->returning_conversation;

        if ($returning_conversation && ($returning_conversation->status != $data['status'])) {
            $returning_conversation->update($data);
        }
    }
}
