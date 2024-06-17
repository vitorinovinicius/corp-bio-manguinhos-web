<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::bind('configuration', function ($value) {return \App\Models\Configuration::where('uuid', $value)->first();});
        Route::bind('user', function ($value) {return \App\Models\User::where('uuid', $value)->first();});
        Route::bind('user_id', function ($value) {return \App\Models\User::where('id', $value)->first();});
        Route::bind('remetente', function ($value) {return \App\Models\User::where('uuid', $value)->first();});
        Route::bind('destinatario', function ($value) {return \App\Models\User::where('uuid', $value)->first();});
        Route::bind('form', function ($value) {return \App\Models\Formulario::where('uuid', $value)->first();});
        Route::bind('sec_form', function ($value) {return \App\Models\SecaoFormulario::where('uuid', $value)->first();});
        Route::bind('general_setting', function($value){return \App\models\GeneralSetting::where('uuid', $value)->first();});
        Route::bind('imagem', function($value){return \App\models\Imagem::where('uuid', $value)->first();});
        Route::bind('document', function($value){return \App\models\Relatorio::where('uuid', $value)->first();});
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
