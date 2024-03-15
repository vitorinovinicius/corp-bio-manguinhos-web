<?php

namespace App\Providers;

use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSection;
use App\Models\Occurrence;
use App\Models\OccurrenceClient;
use App\Observers\FormFieldModelObserver;
use App\Observers\FormModelObserver;
use App\Observers\FormSectionModelObserver;
use App\Observers\OccurrenceClientModelObserver;
use App\Observers\OccurrenceModelObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(RepositoryServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        JsonResource::withoutWrapping();

//        OccurrenceClient::observe(OccurrenceClientModelObserver::class);
        Form::observe(FormModelObserver::class);
        FormField::observe(FormFieldModelObserver::class);
        FormSection::observe(FormSectionModelObserver::class);
        Occurrence::observe(OccurrenceModelObserver::class);
    }
}
