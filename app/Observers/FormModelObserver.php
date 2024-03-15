<?php

namespace App\Observers;

use App\Models\Form;
use Carbon\Carbon;

class FormModelObserver
{
    /**
     * Handle the type service "creating" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function creating(Form $form)
    {
        $form->version_date = Carbon::now();
        $form->version = $form->version + 1;
    }

    /**
     * Handle the type service "updating" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function updating(Form $form)
    {
        $form->version_date = Carbon::now();
        $form->version = $form->version + 1;
    }

    /**
     * Handle the type service "deleted" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function deleted(Form $form)
    {
        //
    }

    /**
     * Handle the type service "restored" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function restored(Form $form)
    {
        //
    }

    /**
     * Handle the type service "force deleted" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function forceDeleted(Form $form)
    {
        //
    }
}
