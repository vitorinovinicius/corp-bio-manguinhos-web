<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\CancelamentoStatus;
use App\Services\CancelamentoStatusService;
use Illuminate\Http\Request;

class CancelamentoStatusController extends Controller {

    /**
     * @var CancelamentoStatusService
     */
    private $cancelamentoStatusService;

    /**
     * CancelamentoStatusController constructor.
     */
    public function __construct(CancelamentoStatusService $cancelamentoStatusService)
    {
        $this->cancelamentoStatusService = $cancelamentoStatusService;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
    {
        return $this->cancelamentoStatusService->index();
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
    {
        return $this->cancelamentoStatusService->create();
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
    {
        return $this->cancelamentoStatusService->store($request);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(CancelamentoStatus $model)
    {
        return $this->cancelamentoStatusService->show($model);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(CancelamentoStatus $model)
    {
        return $this->cancelamentoStatusService->edit($model);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request,CancelamentoStatus $model)
    {
        return $this->cancelamentoStatusService->update($model,$request);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(CancelamentoStatus $model)
    {
        return $this->cancelamentoStatusService->destroy($model);
    }
}
