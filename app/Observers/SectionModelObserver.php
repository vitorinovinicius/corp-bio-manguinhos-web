<?php

namespace App\Observers;

use App\Models\Section;
use Carbon\Carbon;

class SectionModelObserver
{
    /**
     * Handle the section "created" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function creating(Section $section)
    {
//        $typeService = $section->type_service;
//
//        if ($typeService) {
//            $typeService->version_date = Carbon::now();
//            $typeService->save();
//        }
    }

    /**
     * Handle the section "updated" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function updating(Section $section)
    {
//        $typeService = $section->type_service;
//
//        if ($typeService) {
//            $typeService->version_date = Carbon::now();
//            $typeService->save();
//        }

    }

    /**
     * Handle the section "deleting" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function deleting(Section $section)
    {
        $typeService = $section->type_service;

        if ($typeService) {
            $typeService->version_date = Carbon::now();
            $typeService->save();
        }
    }

    /**
     * Handle the section "restored" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function restored(Section $section)
    {
        //
    }

    /**
     * Handle the section "force deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function forceDeleted(Section $section)
    {
        //
    }
}
