<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ContractorOccurrenceType;
use App\Services\ContractorOccurrenceTypeService;
use Illuminate\Http\Request;

class ContractorOccurrenceTypeController extends Controller {
    /**
     * @var ContractorOccurrenceTypeService
     */
    private $contractorOccurrenceTypeService;

    /**
     * @param ContractorOccurrenceTypeService $contractorOccurrenceTypeService
     */
    public function __construct(ContractorOccurrenceTypeService $contractorOccurrenceTypeService)
    {
        $this->contractorOccurrenceTypeService = $contractorOccurrenceTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->contractorOccurrenceTypeService->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \App\Services\Response
     */
    public function create()
    {
        return $this->contractorOccurrenceTypeService->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \App\Services\Response
     */
    public function store(Request $request)
    {
        return $this->contractorOccurrenceTypeService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param ContractorOccurrenceType $model
     * @return Response
     */
    public function show(ContractorOccurrenceType $model)
    {
        return $this->contractorOccurrenceTypeService->show($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ContractorOccurrenceType $model
     * @return \App\Services\Response
     */
    public function edit(ContractorOccurrenceType $model)
    {
        return $this->contractorOccurrenceTypeService->edit($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ContractorOccurrenceType $model
     * @return \App\Services\Response
     */
    public function update(Request $request,ContractorOccurrenceType $model)
    {
        return $this->contractorOccurrenceTypeService->update($model,$request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ContractorOccurrenceType $model
     * @return \App\Services\Response
     */
    public function destroy(ContractorOccurrenceType $model)
    {
        return $this->contractorOccurrenceTypeService->destroy($model);
    }
}
