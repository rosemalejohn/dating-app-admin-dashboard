<?php

namespace App\Console\Commands;

use App\Config;
use App\Services\ProfileService;
use App\Services\TenantService;
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
    public function handle(ProfileService $profile, TenantService $tenant)
    {
        $websites = Website::all();

        $auto_login_fake_accounts = Config::whereKey('auto_login_fake_accounts')->first();

        if ($auto_login_fake_accounts) {
            $count = Config::whereKey('auto_login_fake_accounts_per_cron_job')->first();

            foreach ($websites as $website) {

                $tenant->connect($website);

                $managed_users = $website->managed_users->random()->take($count->value);

                foreach ($managed_users as $managed_user) {
                    $user = $managed_user->user;
                    if ($user) {
                        $profile->login($user);
                    }

                }
            }
        }

    }
}
