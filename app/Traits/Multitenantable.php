<?php

namespace App\Traits;


use App\Tenant\TenantScope;

trait Multitenantable
{
    public static function bootMultitenantable()
    {
        static::addGlobalScope(new TenantScope());

        //Inserir de forma automática o contractor_id no momento do store
        static::creating(function ($model) {
            $contractor = \Tenant::getTenant();
            
            if ($contractor) {
                $model->contractor_id = $contractor->id;
            }
        });
    }
}