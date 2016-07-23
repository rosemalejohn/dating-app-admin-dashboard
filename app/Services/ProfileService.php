<?php namespace App\Services;

use App\Tenant\User;
use Illuminate\Database\QueryException;

class ProfileService
{

    public function login(User $user)
    {
        $timestamp = time();
        $user->activityStamp = $timestamp;
        $user->save();

        try {
            $user->online()->create([
                'activityStamp' => $timestamp,
                'context' => 1,
            ]);

            echo "User {$user->username} logged in!\n";
        } catch (QueryException $e) {
            echo "User {$user->username} is already logged in into the system.\n";
        }
    }

}
