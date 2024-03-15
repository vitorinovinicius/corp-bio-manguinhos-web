<?php

namespace App\Http\Controllers;

use App\Models\PlanOccurrence;
use Illuminate\Http\Request;
use App\Services\PlanOccurrenceService;
use App\Services\OccurrenceService;

class PlanOccurrenceController extends Controller
{

    private $planOccurrenceService;
    private $occurrenceService;
    
    public function __construct(PlanOccurrenceService $planOccurrenceService, OccurrenceService $occurrenceService)
    {
        $this->planOccurrenceService = $planOccurrenceService;
        $this->occurrenceService = $occurrenceService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->planOccurrenceService->listPlanOccurrences();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->planOccurrenceService->createPlanOccurrences();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->planOccurrenceService->storePlanOccurrence($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PlanOccurrence $planOccurrence)
    {
        return $this->planOccurrenceService->showPlanOccurrence($planOccurrence);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanOccurrence $planOccurrence)
    {
        return $this->planOccurrenceService->editPlanOccurrence($planOccurrence);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlanOccurrence $planOccurrence)
    {
        return $this->planOccurrenceService->updatePlanOccurrence($request, $planOccurrence);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlanOccurrence $planOccurrence)
    {
        return $this->planOccurrenceService->destroyPlanOccurrence($planOccurrence);
    }

    public function createOccurrence()
    {
        return $this->occurrenceService->planOSCreate();
    }
}
