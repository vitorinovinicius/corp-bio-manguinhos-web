<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Financial;
use App\Models\FinancialCommunication;
use App\Services\FinancialCommunicationService;
use App\Http\Requests\FinancialCommunicationRequest;
use Illuminate\Http\Request;

class FinancialCommunicationController extends Controller {

    /**
     * @var FinancialCommunicationService
     */
    private $financialCommunicationService;

    /**
     * FinancialCommunicationController constructor.
     */
    public function __construct(FinancialCommunicationService $financialCommunicationService)
    {
        $this->financialCommunicationService = $financialCommunicationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
	public function index(Request $request)
    {
        return $this->financialCommunicationService->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Financial $financial
     * @return \App\Services\Response
     */
	public function create(Financial $financial)
    {
        return $this->financialCommunicationService->create($financial);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Financial $financial
     * @param FinancialCommunicationRequest $request
     * @return \App\Services\Response
     */
	public function store(Financial $financial, FinancialCommunicationRequest $request)
    {
        return $this->financialCommunicationService->store($financial, $request);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(FinancialCommunication $model)
    {
        return $this->financialCommunicationService->show($model);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(FinancialCommunication $model)
    {
        return $this->financialCommunicationService->edit($model);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(FinancialCommunicationRequest $request,FinancialCommunication $model)
    {
        return $this->financialCommunicationService->update($model,$request);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(FinancialCommunication $model)
    {
        return $this->financialCommunicationService->destroy($model);
    }
}
