<?php

namespace App\Observers;

use App\Models\Form;
use App\Models\FormField;
use Carbon\Carbon;

class FormFieldModelObserver
{
    /**
     * Handle the type service "creating" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function creating(FormField $formField)
    {
        $formSection = $formField->form_section;
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
    public function updating(FormField $formField)
    {

        $formSection = $formField->form_section;
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
    public function deleted(FormField $form)
    {
        //
    }

    /**
     * Handle the type service "restored" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function restored(FormField $form)
    {
        //
    }

    /**
     * Handle the type service "force deleted" event.
     *
     * @param  \App\Models\Form  $form
     * @return void
     */
    public function forceDeleted(FormField $form)
    {
        //
    }
}
