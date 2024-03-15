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

        Route::bind('app_version', function ($value) {return \App\Models\AppVersion::where('uuid', $value)->first();});
        Route::bind('cancelamento_status', function ($value) {return \App\Models\CancelamentoStatus::where('id', $value)->first();});
        Route::bind('configuration', function ($value) {return \App\Models\Configuration::where('uuid', $value)->first();});
        Route::bind('user', function ($value) {return \App\Models\User::where('uuid', $value)->first();});
        Route::bind('operator', function ($value) {return \App\Models\User::where('uuid', $value)->first();});
        Route::bind('contractor', function ($value) {return \App\Models\Contractor::where('uuid', $value)->first();});
        Route::bind('move-type', function ($value) {return \App\Models\MoveType::where('uuid', $value)->first();});
        Route::bind('occurrence', function ($value) {return \App\Models\Occurrence::where('uuid', $value)->first();});
        Route::bind('occurrence_client', function ($value) {return \App\Models\OccurrenceClient::where('uuid', $value)->first();});
        Route::bind('occurrence_data_basic', function ($value) {return \App\Models\OccurrenceDataBasic::where('uuid', $value)->first();});
        Route::bind('occurrence_image', function ($value) {return \App\Models\OccurrenceImage::where('uuid', $value)->first();});
        Route::bind('occurrence_type', function ($value) {return \App\Models\OccurrenceType::where('uuid', $value)->first();});
        Route::bind('team', function ($value) {return \App\Models\Team::where('uuid', $value)->first();});
        Route::bind('interference', function ($value) {return \App\Models\Interference::where('uuid', $value)->first();});
        Route::bind('traking', function ($value) {return \App\Models\Traking::where('uuid', $value)->first();});
        Route::bind('log_import', function ($value) {return \App\Models\LogImport::where('uuid', $value)->first();});
        Route::bind('log_import_error', function ($value) {return \App\Models\LogImportError::where('uuid', $value)->first();});
        Route::bind('form', function ($value) {return \App\Models\Form::where('uuid', $value)->first();});
        Route::bind('form_section', function ($value) {return \App\Models\FormSection::where('uuid', $value)->first();});
        Route::bind('form_field', function ($value) {return \App\Models\FormField::where('uuid', $value)->first();});
        Route::bind('form_group', function ($value) {return \App\Models\FormGroup::where('uuid', $value)->first();});
        Route::bind('occurrence_type_form', function ($value) {return \App\Models\OccurrenceTypeForm::where('uuid', $value)->first();});
        Route::bind('document', function ($value) {return \App\Models\Document::where('uuid', $value)->first();});
        Route::bind('sms', function ($value) {return \App\Models\Sms::where('uuid', $value)->first();});
        Route::bind('log_local', function ($value) {return \App\Models\LogLocal::where('uuid', $value)->first();});
        Route::bind('financial', function ($value) {return \App\Models\Financial::where('uuid', $value)->first();});
        Route::bind('financial_communication', function ($value) {return \App\Models\FinancialCommunication::where('uuid', $value)->first();});
        Route::bind('occurrence_archives', function ($value) {return \App\Models\OccurrenceArchive::where('uuid', $value)->first();});
        Route::bind('finish_work_day', function ($value) {return \App\Models\FinishWorkDay::where('uuid', $value)->first();});
        Route::bind('vehicle', function ($value) {return \App\Models\Vehicle::where('uuid', $value)->first();});
        Route::bind('checklist_vechicle_itens', function ($value){return \App\Models\ChecklistVehicleIten::where('uuid', $value)->first();});
        Route::bind('checklist_vehicle', function ($value) {return \App\Models\ChecklistVehicleBasic::where('uuid', $value)->first();});
        Route::bind('district', function ($value) {return \App\Models\District::where('uuid', $value)->first();});
        Route::bind('contractor_district', function ($value) {return \App\Models\ContractorDistrict::where('uuid', $value)->first();});
        Route::bind('contractor_occurrence_type', function ($value) {return \App\Models\ContractorOccurrenceType::where('uuid', $value)->first();});
        Route::bind('alert', function ($value) {return \App\Models\Alert::where('uuid', $value)->first();});
        Route::bind('skill', function ($value) {return \App\Models\Skill::where('uuid', $value)->first();});
        Route::bind('equipment', function($value) {return \App\Models\Equipment::where('uuid',$value)->first();});

        Route::bind('category', function($value) {return \App\Models\Category::where('uuid',$value)->first();});
        Route::bind('product', function($value) {return \App\Models\Product::where('uuid',$value)->first();});

        Route::bind('general_setting', function($value){return \App\models\GeneralSetting::where('uuid', $value)->first();});

        Route::bind('evaluation', function($value){return \App\Models\Evaluation::where('uuid', $value)->first();});
        Route::bind('routing', function($value){return \App\Models\Routing::where('uuid', $value)->first();});

        Route::bind('expense_types', function($value){return \App\Models\ExpenseTypes::where('uuid', $value)->first();});
        Route::bind('expense', function($value){return \App\Models\Expense::where('uuid', $value)->first();});
        Route::bind('plan_occurrence', function($value){return \App\Models\PlanOccurrence::where('uuid', $value)->first();});

        Route::bind('workday', function($value){return \App\Models\Workday::where('uuid', $value)->first();});
        Route::bind('workday_program', function($value){return \App\Models\WorkdayPrograms::where('uuid', $value)->first();});

        Route::bind('address', function($value){return \App\Models\Address::where('uuid', $value)->first();});

        Route::bind('zone', function($value){return \App\Models\Zone::where('uuid', $value)->first();});

        Route::bind('occurrence_pdf', function($value){return \App\Models\OccurrencePdf::where('uuid', $value)->first();});

        Route::bind('ticket', function($value){return \App\Models\Ticket::where('uuid', $value)->first();});
        Route::bind('group', function($value){return \App\Models\Group::where('uuid', $value)->first();});
        Route::bind('ticket_type', function($value){return \App\Models\TicketType::where('uuid', $value)->first();}); 
        Route::bind('ticket_type_section', function($value){return \App\Models\TicketTypeSection::where('uuid', $value)->first();}); 
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
