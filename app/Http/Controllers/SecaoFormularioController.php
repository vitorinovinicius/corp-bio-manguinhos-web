<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SecaoFormulario;
use App\Models\Formulario;
use App\Services\SecaoFormularioService;

class SecaoFormularioController extends Controller
{

    /**
     * @var SecaoFormularioService
     */
    private $secaoFormService;

    /**
     * FormController constructor.
     */
    public function __construct(SecaoFormularioService $secaoFormService)
    {
        $this->secaoFormService = $secaoFormService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->secaoFormService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function consulta_ajax(Formulario $formulario)
    {
        return $this->secaoFormService->consulta_ajax($formulario);
    }

    public function envioEmail()
    {
        return $this->secaoFormService->envioEmail();
    }
}
