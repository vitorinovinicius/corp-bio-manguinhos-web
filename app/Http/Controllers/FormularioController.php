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

	public function index(Request $request)
    {
        return $this->formService->index($request);
    }
	
	public function create()
    {
        return $this->formService->create();
    }

	public function store(FormularioRequest $request)
    {
        return $this->formService->store($request);
    }

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

	public function edit(Formulario $formulario)
    {
        return $this->formService->edit($formulario);
    }

	public function update(Request $request,Formulario $formulario)
    {
        return $this->formService->update($request, $formulario);
    }

	public function destroy($formulario)
    {
        return $this->formService->destroy($formulario);
    }

	public function iniciar($usuario, $formulario)
	{
		return $this->formService->iniciar($usuario, $formulario);
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
