<?php

namespace App\Policies;

use App\User;
use App\Website;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebsitePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function view(User $user, Website $website)
    {
        $result = $user->managed_websites()->where('website_id', $website->id)->first();
        if ($result) {
            return true;
        }
    }
}
