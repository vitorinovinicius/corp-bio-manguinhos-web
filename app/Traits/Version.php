<?php

namespace App\Traits;

trait Version
{

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->version = $model->version + 1;
        });
    }
}