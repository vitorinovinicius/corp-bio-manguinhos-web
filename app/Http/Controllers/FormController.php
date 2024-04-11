<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Form;
use App\Services\FormService;
use App\Http\Requests\FormGRequest;
use App\Models\Formulario;
use Illuminate\Http\Request;

class FormController extends Controller {

    /**
     * @var FormService
     */
    private $formService;

    /**
     * FormController constructor.
     */
    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \App\Services\Response
	 */
	public function index(Request $request)
    {
        return $this->formService->index($request);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \App\Services\Response
	 */
	public function create()
    {
        return $this->formService->create();
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \App\Services\Response
	 */
	public function store(Request $request)
    {
        return $this->formService->store($request);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \App\Services\Response
	 */
	public function show(Formulario $model)
    {
        return $this->formService->show($model);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \App\Services\Response
	 */
	public function edit(Formulario $model)
    {
        return $this->formService->edit($model);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return \App\Services\Response
	 */
	public function update(Request $request,Formulario $model)
    {
        return $this->formService->update($model,$request);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \App\Services\Response
	 */
	public function destroy(Formulario $model)
    {
        return $this->formService->destroy($model);
    }
}
