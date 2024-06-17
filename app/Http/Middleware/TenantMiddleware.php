<?php

namespace App\Http\Middleware;

use Closure;

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
        $user    = \Auth::user();
        $driver  = \Auth::getDefaultDriver();

        // libera a requisicao para usuarios da API
        if ($driver == "api") {
            return $next($request);
        }

        return $next($request);
    }
}
