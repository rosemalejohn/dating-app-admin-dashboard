<?php

namespace App\Console\Commands;

use App\Config;
use App\Services\ProfileService;
use App\Services\TenantService;
use App\Tenant\User;
use App\Website;
use Illuminate\Console\Command;

class LoginAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Login account on all sites.';

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
    public function handle(ProfileService $profile, TenantService $tenant)
    {
        $websites = Website::all();

        $auto_login_fake_accounts = Config::whereKey('auto_login_entire_site')->first();

        if ($auto_login_fake_accounts->value == 1) {
            $count = Config::whereKey('auto_login_accounts_per_cron_jobs')->first();

            foreach ($websites as $website) {
                $tenant->connect($website);

                $users = User::limit($count->value)->inRandomOrder()->get();

                foreach ($users as $user) {
                    if ($user) {
                        $profile->login($user);
                    }
                }
            }
        }
    }
}
