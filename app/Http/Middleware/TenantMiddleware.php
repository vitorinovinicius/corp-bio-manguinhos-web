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
        $contractor = null;

         // Ignora a empresa do superuser ou usuario da empresa CS
         if (! $user->isSuperUser()) {
            $contractor = $user->contractor;
        }
     
        \Tenant::setTenant($contractor);

        // libera a requisicao para usuarios da API
        if ($driver == "api") {
            return $next($request);
        }

        return $next($request);
    }
}
