<?php

namespace App\Http\Middleware;

use App\Services\TenantService;
use App\Website;
use Closure;
use Route;

class TenantMiddleware
{

    protected $tenant;

    public function __construct(TenantService $tenant)
    {
        $this->tenant = $tenant;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $website = Route::current()->getParameter('website');

        if (is_string($website)) {
            $website = Website::find((int) $website);
            $this->tenant->connect($website);
        } elseif ($website) {
            $this->tenant->connect($website);
        }
        return $next($request);
    }
}
