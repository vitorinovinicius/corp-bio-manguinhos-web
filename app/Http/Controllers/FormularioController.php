<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Formulario;
use Illuminate\Http\Request;
use App\Services\FormularioService;
use App\Http\Requests\FormularioRequest;

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
	public function store(FormularioRequest $request)
    {
        return $this->formService->store($request);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \App\Services\Response
	 */
	public function show($formulario)
    {
        return $this->formService->show($formulario);
    }

	public function preenchimento($formulario)
    {
        return $this->formService->preenchimento($formulario);
    }

	public function vincula($formulario)
    {
        return $this->formService->vincula($formulario);
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

	public function inicia_ajax($formulario)
    {
        return $this->formService->inicia_ajax($formulario);
    }

	public function confirmacao($user, $secao)
    {
        return $this->formService->confirmacao($user, $secao);
    }
}
