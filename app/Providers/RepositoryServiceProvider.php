<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\SecaoFormularioRepository::class, \App\Repositories\SecaoFormularioRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ConfigurationRepository::class, \App\Repositories\ConfigurationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ActivityLogRepository::class, \App\Repositories\ActivityLogRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserSetoresRepository::class, \App\Repositories\UserSetoresRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SecaoImagemRepository::class, \App\Repositories\SecaoImagemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FormularioRepository::class, \App\Repositories\FormularioRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RelatorioRepository::class, \App\Repositories\RelatorioRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ImagemRepository::class, \App\Repositories\ImagemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SetorRepository::class, \App\Repositories\SetorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmailRepository::class, \App\Repositories\EmailRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
    }

}
