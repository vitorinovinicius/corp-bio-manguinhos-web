<?php

namespace App\Http\Middleware;

use Closure;
use Cache;

class SystemConfiguration
{
    public $settings;


    public function __construct(\App\Models\Configuration $settings)
    {
        $this->settings = $settings;
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
        $settings = Cache::get('settings');
        if(empty($settings) === true){
            $settings = $this->settings->getSettings();
            Cache::forever('settings', $settings);
        }

        if(empty($settings) === false){
            config($settings);
        }

        return $next($request);
    }
}
