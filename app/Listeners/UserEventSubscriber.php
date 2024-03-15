<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    /**
     * Monitora os eventos de login e direciona para ação de pós login
     * que é o método OnUserLogin
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );
    }

    /**
     * Registrar um token de acesso
     * @param $event
     */
    public function onUserLogin($event)
    {
        $tokenAccess = bcrypt(date('YmdHms'));

        $user = auth()->user();
        $user->token_access = $tokenAccess;
        $user->save();

        session()->put('access_token', $tokenAccess);
    }
}
