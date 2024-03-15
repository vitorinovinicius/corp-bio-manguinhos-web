<?php

namespace App\Observers;

use App\Models\OccurrenceClient;

class OccurrenceClientModelObserver
{

    public function creating(OccurrenceClient $occurrenceClient)
    {
//        if($contractor_id = request()->input('contractor_id')) {
//            $occurrenceClient->contractor_id = $contractor_id;
//        }
    }

    /**
     * Handle the occurrence client "created" event.
     *
     * @param  \App\Models\OccurrenceClient  $occurrenceClient
     * @return void
     */
    public function created(OccurrenceClient $occurrenceClient)
    {

    }

    /**
     * Handle the occurrence client "updated" event.
     *
     * @param  \App\Models\OccurrenceClient  $occurrenceClient
     * @return void
     */
    public function updated(OccurrenceClient $occurrenceClient)
    {
        //
    }

    /**
     * Handle the occurrence client "deleted" event.
     *
     * @param  \App\Models\OccurrenceClient  $occurrenceClient
     * @return void
     */
    public function deleted(OccurrenceClient $occurrenceClient)
    {
        //
    }

    /**
     * Handle the occurrence client "restored" event.
     *
     * @param  \App\Models\OccurrenceClient  $occurrenceClient
     * @return void
     */
    public function restored(OccurrenceClient $occurrenceClient)
    {
        //
    }

    /**
     * Handle the occurrence client "force deleted" event.
     *
     * @param  \App\Models\OccurrenceClient  $occurrenceClient
     * @return void
     */
    public function forceDeleted(OccurrenceClient $occurrenceClient)
    {
        //
    }
}
