<?php

use Illuminate\Database\Seeder;
use App\AffiliateUser;

class AffiliateUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         AffiliateUser::create([
            'name' => 'Affiliate User',
            'email' => 'affiliate@n8core.com',
            'password' => bcrypt('affiliate')
        ]);
    }
}
