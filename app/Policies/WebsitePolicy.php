<?php

namespace App\Policies;

use App\Services\ConfigService;
use App\User;
use App\Website;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebsitePolicy
{
    use HandlesAuthorization;

    public $config;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(ConfigService $config)
    {
        $this->config = $config;
    }

    public function view(User $user, Website $website)
    {
        $result = $user->managed_websites()->where('website_id', $website->id)->first();
        if ($result or auth()->user()->is_admin or auth()->user()->is_super) {
            return true;
        }
    }

    public function store(User $user, Website $website)
    {
        if ($user->is_admin or $user->is_super) {
            if ($this->config->getConfigValue('allow_site_limit')) {
                $allowed_sites = $this->config->getConfigValue('site_limit');
                if (Website::all()->count() < $allowed_sites) {
                    return true;
                }
            }
        }
    }
}
