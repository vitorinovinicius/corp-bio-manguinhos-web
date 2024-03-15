<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\OccurrenceType;
use Illuminate\Http\Request;
use App\Services\OccurrenceTypeService;

class OccurrenceTypeController extends Controller {
    /**
     * @var OccurrenceTypeService
     */
    private $occurrenceTypeService;
    /**
     * @var OccurrenceType
     */
    private $occurrenceType;

    /**
     * OccurrenceTypeController constructor.
     * @param OccurrenceTypeService $occurrenceTypeService
     * @param OccurrenceType $occurrenceType
     */
    public function __construct(OccurrenceTypeService $occurrenceTypeService, OccurrenceType $occurrenceType)
    {
        $this->occurrenceTypeService = $occurrenceTypeService;
        $this->occurrenceType = $occurrenceType;
    }


    public function index(Request $request)
    {
        return $this->occurrenceTypeService->index($request);
    }


    public function create()
    {
        return $this->occurrenceTypeService->create();
    }


    public function store(Request $request)
    {
        return $this->occurrenceTypeService->store($request);
    }

    public function show(OccurrenceType $occurrenceType)
    {
        return $this->occurrenceTypeService->show($occurrenceType);
    }


    public function edit(OccurrenceType $occurrenceType)
    {
        return $this->occurrenceTypeService->edit($occurrenceType);
    }


    public function update(Request $request, OccurrenceType $occurrenceType)
    {
        return $this->occurrenceTypeService->update($request, $occurrenceType);
    }


    public function destroy(OccurrenceType $occurrenceType)
    {
        return $this->occurrenceTypeService->destroy($occurrenceType);
    }

}
