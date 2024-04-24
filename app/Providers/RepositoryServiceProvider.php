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
        $this->app->bind(\App\Repositories\ActivityLogRepository::class, \App\Repositories\ActivityLogRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TeamRepository::class, \App\Repositories\TeamRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\InterferenceRepository::class, \App\Repositories\InterferenceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OccurrenceRepository::class, \App\Repositories\OccurrenceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OccurrenceTypeRepository::class, \App\Repositories\OccurrenceTypeRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceClientRepository::class, \App\Repositories\OccurrenceClientRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceClientPhoneRepository::class, \App\Repositories\OccurrenceClientPhoneRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceDataBasicRepository::class, \App\Repositories\OccurrenceDataBasicRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceImageRepository::class, \App\Repositories\OccurrenceImageRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\LogImportRepository::class, \App\Repositories\LogImportRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\LogImportErrorRepository::class, \App\Repositories\LogImportErrorRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ReallocationRepository::class, \App\Repositories\ReallocationRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ContractorRepository::class, \App\Repositories\ContractorRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\RegionRepository::class, \App\Repositories\RegionRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\AppVersionRepository::class, \App\Repositories\AppVersionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ConfigurationRepository::class, \App\Repositories\ConfigurationRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\TrakingRepository::class, \App\Repositories\TrakingRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\CancelamentoStatusRepository::class, \App\Repositories\CancelamentoStatusRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\MoveRepository::class, \App\Repositories\MoveRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\MoveTypeRepository::class, \App\Repositories\MoveTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FormRepository::class, \App\Repositories\FormRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FormGroupRepository::class, \App\Repositories\FormGroupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FormSectionRepository::class, \App\Repositories\FormSectionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FormFieldRepository::class, \App\Repositories\FormFieldRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceTypeFormRepository::class, \App\Repositories\OccurrenceTypeFormRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceFormFieldRepository::class, \App\Repositories\OccurrenceFormFieldRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceDataClientRepository::class, \App\Repositories\OccurrenceDataClientRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ExecutionRepository::class, \App\Repositories\ExecutionRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\DocumentRepository::class, \App\Repositories\DocumentRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\SmsRepository::class, \App\Repositories\SmsRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\LogLocalRepository::class, \App\Repositories\LogLocalRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\FinancialRepository::class, \App\Repositories\FinancialRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\FinancialCommunicationRepository::class, \App\Repositories\FinancialCommunicationRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\OccurrenceArchiveRepository::class, \App\Repositories\OccurrenceArchiveRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\FinishWorkDayRepository::class, \App\Repositories\FinishWorkDayRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\VehicleRepository::class, \App\Repositories\VehicleRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ArchiveRepository::class, \App\Repositories\ArchiveRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\ChecklistVehicle\ChecklistVehicleBasicRepository::class, \App\Repositories\ChecklistVehicle\ChecklistVehicleBasicRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ChecklistVehicle\ChecklistVehicleImageRepository::class, \App\Repositories\ChecklistVehicle\ChecklistVehicleImageRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ChecklistVehicle\ChecklistVehicleItemRepository::class, \App\Repositories\ChecklistVehicle\ChecklistVehicleItemRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ChecklistVehicle\ChecklistVehicleRepository::class, \App\Repositories\ChecklistVehicle\ChecklistVehicleRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\DistrictRepository::class, \App\Repositories\DistrictRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ContractorDistrictRepository::class, \App\Repositories\ContractorDistrictRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ContractorOccurrenceTypeRepository::class, \App\Repositories\ContractorOccurrenceTypeRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\AlertRepository::class, \App\Repositories\AlertRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceOrderRepository::class, \App\Repositories\OccurrenceOrderRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\SkillRepository::class, \App\Repositories\SkillRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\OccurrenceTypeSkillRepository::class, \App\Repositories\OccurrenceTypeSkillRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\UserSkillRepository::class, \App\Repositories\UserSkillRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\EquipmentRepository::class, \App\Repositories\EquipmentRepositoryEloquent::class);


        // $this->app->bind(\App\Repositories\CategoryRepository::class, \App\Repositories\CategoryRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\GeneralSettingRepository::class, \App\Repositories\GeneralSettingRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\EvaluationRepository::class, \App\Repositories\EvaluationRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\RoutingRepository::class, \App\Repositories\RoutingRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ExpenseTypesRepository::class, \App\Repositories\ExpenseTypesRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ExpenseRepository::class, \App\Repositories\ExpenseRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\PlanOccurrenceRepository::class, \App\Repositories\PlanOccurrenceRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\WorkdayRepository::class, \App\Repositories\WorkdayRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\WorkdayProgramsRepository::class, \App\Repositories\WorkdayProgramsRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\AddressRepository::class, \App\Repositories\AddressRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\ZoneRepository::class, \App\Repositories\ZoneRepositoryEloquent::class);

        // $this->app->bind(\App\Repositories\OccurrencePdfRepository::class, \App\Repositories\OccurrencePdfRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\TicketRepository::class, \App\Repositories\TicketRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\GroupRepository::class, \App\Repositories\GroupRepositoryEloquent::class);
        // $this->app->bind(\App\Repositories\TicketTypeRepository::class, \App\Repositories\TicketTypeRepositoryEloquent::class);   
        // $this->app->bind(\App\Repositories\TicketTypeSectionRepository::class, \App\Repositories\TicketTypeSectionRepositoryEloquent::class);   
        // $this->app->bind(\App\Repositories\TicketTypeSectionFieldRepository::class, \App\Repositories\TicketTypeSectionFieldRepositoryEloquent::class);   
        // $this->app->bind(\App\Repositories\TicketDataRepository::class, \App\Repositories\TicketDataRepositoryEloquent::class);   
        // $this->app->bind(\App\Repositories\TicketImageRepository::class, \App\Repositories\TicketImageRepositoryEloquent::class);   
        $this->app->bind(\App\Repositories\FormularioRepository::class, \App\Repositories\FormularioRepositoryEloquent::class);   
        $this->app->bind(\App\Repositories\CorpoRepository::class, \App\Repositories\CorpoRepositoryEloquent::class);   
        $this->app->bind(\App\Repositories\SetorRepository::class, \App\Repositories\SetorRepositoryEloquent::class);   
    }

}
