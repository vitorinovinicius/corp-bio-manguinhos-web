<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;


Class TenantScope implements Scope 
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model){

        $contractor = \Tenant::getTenant();      
        
        if($contractor) {
            $builder->where($model->getTable().'.contractor_id', '=', $contractor->id);
        }
    }

}