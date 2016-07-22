<?php

namespace App\Console\Commands;

use App\Services\ProfileService;
use App\Website;
use Illuminate\Console\Command;

class LoginFakeProfiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login:fake-profiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomly login fake profiles';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ProfileService $profile)
    {
        $websites = Website::all();

        foreach ($websites as $website) {
            connectToTenant($website);

            $managed_users = $website->managed_users->random()->all();

            foreach ($managed_users as $managed_user) {
                $user = $managed_user->user;
                $profile->login($user);
            }
        }

    }
}
