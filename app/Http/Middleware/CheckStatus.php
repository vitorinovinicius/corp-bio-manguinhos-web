<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Contractor;


class CheckStatus
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
        if ( auth()->check() ){

            $contractor = auth()->user()->contractor_id;
            $statusContractor = Contractor::select('status')->where('id', $contractor)->first();

            if ($statusContractor != null && ($statusContractor->status != 1 || auth()->user()->status != 1)) {
                \Auth::logout();
                return redirect('/login')->with('error', ' Acesso negado');
            }
        }
        return $next($request);
    }
}
