<?php

namespace App\Observers;

use App\Models\Occurrence;

class OccurrenceModelObserver
{
    /**
     * Handle the type service "creating" event.
     *
     * @param  \App\Models\Occurrence  $occurrence
     * @return void
     */
    public function creating(Occurrence $occurrence)
    {
        //
    }

    /**
     * Handle the type service "updating" event.
     *
     * @param  \App\Models\Occurrence  $occurrence
     * @return void
     */
    public function updating(Occurrence $occurrence)
    {
        $occurrence->version = $occurrence->version + 1;
    }

    /**
     * Handle the type service "deleted" event.
     *
     * @param  \App\Models\Occurrence  $occurrence
     * @return void
     */
    public function deleted(Occurrence $occurrence)
    {
        //
    }

    /**
     * Handle the type service "restored" event.
     *
     * @param  \App\Models\Occurrence  $occurrence
     * @return void
     */
    public function restored(Occurrence $occurrence)
    {
        //
    }

    /**
     * Handle the type service "force deleted" event.
     *
     * @param  \App\Models\Occurrence  $occurrence
     * @return void
     */
    public function forceDeleted(Occurrence $occurrence)
    {
        //
    }
}
