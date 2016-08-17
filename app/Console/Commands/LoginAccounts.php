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
        $config = Config::whereKey('auto_login_entire_site')->first();

        if (!$config->value) {
            return false;
        }

        $websites = Website::all();

        foreach ($websites as $website) {
            $tenant->connect($website);

            $count = Config::whereKey('auto_login_accounts_per_cron_jobs')->first();

            if ($count) {
                $users = User::all()
                    ->random()
                    ->take($count->value)
                    ->get();

                $users->each(function ($user) use ($profile) {
                    $profile->login($user);
                });
            }
        }
    }
}
