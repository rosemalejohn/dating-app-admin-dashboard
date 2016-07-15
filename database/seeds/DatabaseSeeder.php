<?php

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
            'name' => 'Rosemale-John',
            'username' => 'rosemalejohn',
            'email' => 'rosemalejohn@gmail.com',
            'password' => bcrypt('rosemalejohn'),
            'type' => 'admin',
        ]);

        User::create([
            'name' => 'Ricky Mindanao',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user'),
            'type' => 'user',
        ]);
    }
}
