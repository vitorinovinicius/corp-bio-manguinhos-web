<?php

namespace App\Http\Controllers\Api;

use App\Criteria\DocumentCriteria;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\DocumentValueResource;
use App\Repositories\DocumentRepository;
use App\Services\Api\ConfigurationService;
use App\Services\Api\ExpenseTypeService;
use App\Services\Api\OccurrenceTypeService;
use App\Services\InterferenceService;

class ConfigController extends Controller
{

    /**
     * @var ConfigurationService
     */
    private $configurationService;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;
    /**
     * @var OccurrenceTypeService
     */
    private $occurrenceTypeService;
    /**
     * @var InterferenceService
     */
    private $interferenceService;
    /**
     * @var ExpenseTypeService
     */
    private $expenseTypeService;


    /**
     * ConfigController constructor.
     * @param ConfigurationService $configurationService
     * @param DocumentRepository $documentRepository
     * @param OccurrenceTypeService $occurrenceTypeService
     * @param InterferenceService $interferenceService
     * @param ExpenseTypeService $expenseTypeService
     */
    public function __construct(
        ConfigurationService $configurationService,
        DocumentRepository $documentRepository,
        OccurrenceTypeService $occurrenceTypeService,
        InterferenceService $interferenceService,
        ExpenseTypeService $expenseTypeService
    )
    {
        $this->configurationService = $configurationService;
        $this->documentRepository = $documentRepository;
        $this->occurrenceTypeService = $occurrenceTypeService;
        $this->interferenceService = $interferenceService;
        $this->expenseTypeService = $expenseTypeService;
    }

    public function getFullConfig(){
        return $this->configurationService->getAll();
    }

    public function getDocumentos()
    {
        $this->documentRepository->pushCriteria(new DocumentCriteria());
        $documents = DocumentValueResource::collection($this->documentRepository->all());

        return response()->json(["data"=>$documents],200);
    }
    public function getOsType()
    {
        return $this->occurrenceTypeService->getOccurrenceType();
    }
    public function getInterferences()
    {
        return $this->interferenceService->getInterferences();
    }

    public function getExpenseTypes()
    {
        return $this->expenseTypeService->list();
    }
}
