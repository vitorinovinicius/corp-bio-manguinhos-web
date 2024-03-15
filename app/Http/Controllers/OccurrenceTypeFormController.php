<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\OccurrenceTypeForm;
use App\Services\OccurrenceTypeFormService;
use App\Http\Requests\OccurrenceTypeFormRequest;
use Illuminate\Http\Request;

class OccurrenceTypeFormController extends Controller {

    /**
     * @var OccurrenceTypeFormService
     */
    private $occurrenceTypeFormService;

    /**
     * OccurrenceTypeFormController constructor.
     */
    public function __construct(OccurrenceTypeFormService $occurrenceTypeFormService)
    {
        $this->occurrenceTypeFormService = $occurrenceTypeFormService;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(OccurrenceTypeFormRequest $request)
    {
        return $this->occurrenceTypeFormService->index($request);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
    {
        return $this->occurrenceTypeFormService->create();
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(OccurrenceTypeFormRequest $request)
    {
        return $this->occurrenceTypeFormService->store($request);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(OccurrenceTypeForm $model)
    {
        return $this->occurrenceTypeFormService->show($model);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(OccurrenceTypeForm $model)
    {
        return $this->occurrenceTypeFormService->edit($model);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(OccurrenceTypeFormRequest $request,OccurrenceTypeForm $model)
    {
        return $this->occurrenceTypeFormService->update($model,$request);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(OccurrenceTypeForm $model)
    {
        return $this->occurrenceTypeFormService->destroy($model);
    }


	public function atualizaManual()
    {
        return $this->occurrenceTypeFormService->atualizaManual();
    }
}
