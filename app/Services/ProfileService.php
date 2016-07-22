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
        } catch (QueryException $e) {
            echo "User {$user->username} is already logged in into the system.\n";
        }
    }

}
