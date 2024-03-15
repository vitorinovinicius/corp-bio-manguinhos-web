<?php

namespace App\Tenant;

use App\Models\Contractor;
use Illuminate\Database\Schema\Blueprint;

class TenantManager
{
    private $tenant;
    private static $tenantTable = 'contractors';
    private static $tenantField = 'contractor_id';
    private static $tenantModel = Contractor::class;

    /**
     * @return Contractor
     */
    public function getTenant(): ? Contractor // return null or Contractor
    {
        return $this->tenant;
    }

    /**
     * @param Contractor $tenant
     */
    public function setTenant(?Contractor $tenant): void
    {
        $this->tenant = $tenant;
    }

    /**
     * @return string
     */
    public function getTenantTable(): string
    {
        return self::$tenantTable;
    }

    /**
     * @return string
     */
    public function getTenantField(): string
    {
        return self::$tenantField;
    }

    /**
     * @return string
     */
    public function getTenantModel(): string
    {
        return self::$tenantModel;
    }

    /**
     * Cria os campos de relacionamento com o tenant
     * Para usa-los, basta inserir no migration o comando $table->tenant();
     */
    public function BluePtintMacros()
    {
        Blueprint::macro('tenant', function () {
           $this->integer(\Tenant::TenantManager())->unsigned()->nullable();
           $this->foreign(\Tenant::getTenantField())
               ->references('id')
               ->on(\Tenant::getTenantTable());
        });
    }

    /**
     * Retorna campo tenant para Request Validations que possui regras de validacao por exists.
     * Basta concatenar no final
     *
     * @return string
     */
    public function ruleExists()
    {
        return ",{$this->getTenantField()}, {$this->getTenant()->id}";
    }
}