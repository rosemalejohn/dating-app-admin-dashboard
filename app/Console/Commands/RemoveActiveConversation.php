<?php

namespace App\Console\Commands;

use App\ActiveConversation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemoveActiveConversation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active-conversation:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove active conversation every 5 minutes';

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
        $last5minutes = Carbon::now()->subMinutes(5);

        ActiveConversation::where('created_at', '<=', $last5minutes)->delete();
    }
}
