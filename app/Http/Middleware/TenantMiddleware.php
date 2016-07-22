<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class TenantMiddleware
{
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

        if ($website) {
            connectToTenant($website);
        }
        return $next($request);
    }
}
