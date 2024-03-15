<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\StoreService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\OccurrenceService;
use App\Services\OccurrenceTypeService;

class OccurrenceController extends Controller
{
    /**
     * @var OccurrenceService
     */
    private $occurrenceService;
    /**
     * @var OccurrenceTypeService
     */
    private $occurrenceTypeService;
    /**
     * @var StoreService
     */
    private $storeService;

    public function __construct(
        OccurrenceService $occurrenceService,
        OccurrenceTypeService $occurrenceTypeService,
        StoreService $storeService
        )
    {
        $this->occurrenceService = $occurrenceService;
        $this->occurrenceTypeService = $occurrenceTypeService;
        $this->storeService = $storeService;
    }

    //Opened
    public function getOccurrenceOpenedByOperator(){
        return $this->occurrenceService->getOsOpenedByOperator();
    }

    //Opened
    public function getOccurrenceOpenedByOperatorForce(){
        return $this->occurrenceService->getOsOpenedByOperator(true);
    }
    //Opened
    public function getPrevisionByOperator(){
        return $this->occurrenceService->getPrevisionByOperator();
    }
    public function updateOccurrenceApi(Request $occurrenceDataBasicRequest){
        return $this->storeService->storeOccurrence($occurrenceDataBasicRequest);
    }

    public function addNewOccurrenceImageApi(Request $occurrenceDataBasicRequest){
        return $this->occurrenceService->addNewImagemOccurrence($occurrenceDataBasicRequest);
    }

    public function updateOccurrencesStatus(Request $occurrenceRequest){
        return $this->occurrenceService->updateOccurrencesStatus($occurrenceRequest);
    }

    public function storeManualOccurrence(Request $occurrenceDataBasicRequest){
        return $this->occurrenceService->storeManualOccurrence($occurrenceDataBasicRequest);
    }

    public function storeFinishWorkDay(Request $occurrenceRequest){
        return $this->occurrenceService->storeFinishWorkDay($occurrenceRequest);
    }

    public function storeOrderOs(Request $occurrenceRequest){
        return $this->occurrenceService->order($occurrenceRequest);
    }
}
