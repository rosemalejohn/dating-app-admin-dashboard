<?php

namespace App\Console\Commands;

use App\Services\TenantService;
use App\Tenant\Message;
use App\UserSentMessage;
use Illuminate\Console\Command;

class ComputeEarnings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earnings:compute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compute earnings';

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
    public function handle(TenantService $tenant)
    {
        $user_sent_messages = UserSentMessage::with('website')->get();

        foreach ($user_sent_messages as $user_sent_message) {
            $tenant->connect($user_sent_message->website);
            $message = Message::whereId($user_sent_message->message_id)->with('conversation.messages')->first();
            if ($message) {
                $messages = $message->conversation->messages;
                foreach ($messages->all() as $index => $item) {
                    if ($item->id == $message->id) {
                        $this->nextMessage($user_sent_message, $messages, $message, $index);
                    }
                }
            }
        }
    }

    protected function nextMessage($user_sent_message, $messages, $message, $index)
    {
        $index = $index + 1;
        $next = $messages->get($index);
        if ($next && ($next->senderId != $message->senderId)) {
            try {
                $user_sent_message->replies()->create(['message_id' => $next->id]);
            } catch (\Illuminate\Database\QueryException $ex) {}

            return $this->nextMessage($user_sent_message, $messages, $message, $index);
        }
        return null;
    }
}
