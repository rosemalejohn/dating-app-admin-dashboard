<?php

namespace App\Console\Commands;

use App\Config;
use App\Services\TenantService;
use App\Tenant\Guest;
use App\Tenant\User;
use App\Website;
use Illuminate\Console\Command;

class ViewRandomProfiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profiles:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View random profiles';

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
        $allow_fake_profile_views = Config::whereKey('allow_fake_profile_views')->first();

        if ($allow_fake_profile_views->value == 1) {
            $count = Config::whereKey('number_of_profile_view')->first()->value;

            $websites = Website::all();

            foreach ($websites as $website) {

                $tenant->connect($website);

                $managed_users = $website->managed_users;

                foreach ($managed_users as $managed_user) {

                    $users = User::males()->random($count);

                    $managed_user = $managed_user->user;

                    foreach ($users as $user) {
                        $guest = Guest::where('userId', $user->id)->where('guestId', $managed_user->id)->first();
                        if ($guest) {
                            $guest->update(['visitTimestamp' => time()]);
                        } else {
                            $managed_user->guests()->create(['visitTimestamp' => time(), 'userId' => $user->id]);
                        }

                        echo "{$managed_user->username} viewed the profile of {$user->username}.\n";
                    }
                }

            }
        }

    }
}
