<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Services\FormularioService;
use App\Models\Relatorio;
use App\Models\Formulario;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * @var FormularioService
     */
    private $formService;

    /**
     * FormController constructor.
     */
    public function __construct(FormularioService $formService)
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
	public function show(Formulario $formulario)
    {
        return $this->formService->show($formulario);
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \App\Services\Response
	 */
	public function edit(Formulario $formulario)
    {
        return $this->formService->edit($formulario);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return \App\Services\Response
	 */
	public function update(Request $request,Formulario $formulario)
    {
        return $this->formService->update($request, $formulario);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \App\Services\Response
	 */
	public function destroy(Formulario $formulario)
    {
        return $this->formService->destroy($formulario);
    }
}
