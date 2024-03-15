<?php

namespace App\Observers;

use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSection;
use Carbon\Carbon;

class FormSectionModelObserver
{
    /**
     * Handle the type service "creating" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function creating(FormSection $formSection)
    {
        $form = $formSection->form;

        $form->version_date = Carbon::now();
        $form->save();
    }

    /**
     * Handle the type service "updating" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function updating(FormSection $formSection)
    {

        $form = $formSection->form;

        $form->version_date = Carbon::now();
        $form->save();
    }

    /**
     * Handle the type service "deleted" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function deleted(FormSection $form)
    {
        //
    }

    /**
     * Handle the type service "restored" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function restored(FormSection $form)
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
