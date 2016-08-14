<?php

use App\Config;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default database user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@n8core.com',
            'password' => bcrypt('admin'),
            'type' => 'super',
        ]);

        Config::create([
            'key' => 'auto_login_entire_site',
            'name' => 'Auto login (entire site)',
            'value' => true,
            'description' => 'Allow auto login for entire site',
        ]);

        Config::create([
            'key' => 'auto_login_accounts_per_cron_jobs',
            'name' => 'Number of accounts to login per cron jobs',
            'value' => 10,
            'description' => 'Number of accounts per cron job to login if auto login is checked',
        ]);

        Config::create([
            'key' => 'auto_login_fake_accounts',
            'name' => 'Auto login fake accounts',
            'value' => true,
            'description' => 'Entire Site & this Option can not both be checked',
        ]);

        Config::create([
            'key' => 'auto_login_fake_accounts_per_cron_job',
            'name' => 'Number of fake accounts to login',
            'value' => 10,
            'description' => 'If auto login fake accounts is selected',
        ]);

        Config::create([
            'key' => 'allow_intro_message_sent_to_male_members',
            'name' => 'Trigger/Intro Messages to new male members',
            'value' => true,
            'description' => 'Send intro message to new male members',
        ]);

        Config::create([
            'key' => 'number_of_messages_per_cron_job',
            'name' => 'Home many messages per Cron Job',
            'value' => 5,
            'description' => 'Messages to be sent to male members per cron jobs',
        ]);

        Config::create([
            'key' => 'currency',
            'name' => 'Select currency',
            'value' => 'USD',
            'description' => 'System currency',
        ]);

        Config::create([
            'key' => 'allow_site_limit',
            'name' => 'Allow site limit',
            'value' => true,
            'description' => 'Enable site limit for every client (for super user only)',
        ]);

        Config::create([
            'key' => 'site_limit',
            'name' => 'Set site limit',
            'value' => 5,
            'description' => 'Site limit count for every client (for super user only)',
        ]);
    }
}
