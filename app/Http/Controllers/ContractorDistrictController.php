<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ContractorDistrict;
use App\Services\ContractorDistrictService;
use Illuminate\Http\Request;

class ContractorDistrictController extends Controller {
    /**
     * @var ContractorDistrictService
     */
    private $contractorDistrictService;

    /**
     * @param ContractorDistrictService $contractorDistrictService
     */
    public function __construct(ContractorDistrictService $contractorDistrictService)
    {
        $this->contractorDistrictService = $contractorDistrictService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->contractorDistrictService->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \App\Services\Response
     */
    public function create()
    {
        return $this->contractorDistrictService->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \App\Services\Response
     */
    public function store(Request $request)
    {
        return $this->contractorDistrictService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param ContractorDistrict $model
     * @return Response
     */
    public function show(ContractorDistrict $model)
    {
        return $this->contractorDistrictService->show($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ContractorDistrict $model
     * @return \App\Services\Response
     */
    public function edit(ContractorDistrict $model)
    {
        return $this->contractorDistrictService->edit($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ContractorDistrict $model
     * @return \App\Services\Response
     */
    public function update(Request $request, ContractorDistrict $model)
    {
        return $this->contractorDistrictService->update($model,$request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ContractorDistrict $model
     * @return \App\Services\Response
     */
    public function destroy(ContractorDistrict $model)
    {
        return $this->contractorDistrictService->destroy($model);
    }
}
