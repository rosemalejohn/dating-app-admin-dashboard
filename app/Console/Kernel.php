<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\LoginFakeProfiles::class,
        Commands\SendMessage::class,
        Commands\RemoveActiveConversation::class,
        Commands\ComputeEarnings::class,
        Commands\LoginAccounts::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('login:fake-profiles')
        //     ->daily();
        // $schedule->command('message:send')
        //     ->daily();
    }
}
