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
     * SecaoFormularioController constructor.
     */
    public function __construct(SecaoFormularioService $secaoFormService)
    {
        $this->secaoFormService = $secaoFormService;
    }

    public function store(Request $request)
    {
        return $this->secaoFormService->store($request);
    }

    public function update(Request $request, $secao)
    {
        return $this->secaoFormService->update($request, $secao);
    }

    public function atualiza_texto(Request $request, $secao)
    {
        return $this->secaoFormService->atualiza_texto($request, $secao);
    }

    public function status($sec_form, $status)
    {
        return $this->secaoFormService->status($sec_form, $status);
    }

    public function correcao(Request $request,$sec_form, $user)
    {
        return $this->secaoFormService->correcao($request,$sec_form, $user);
    }

    public function email_correcao(Request $request,$sec_form, $destinatario)
    {
        return $this->secaoFormService->email_correcao($request,$sec_form, $destinatario);
    }
    
    public function consulta_ajax(Formulario $formulario)
    {
        return $this->secaoFormService->consulta_ajax($formulario);
    }
    
    public function todos_email()
    {
        return $this->secaoFormService->todos_email();
    }

    public function enviado()
    {
        return $this->secaoFormService->enviado();
    }
    
    public function confirmado()
    {
        return $this->secaoFormService->confirmado();
    }

    public function destroy($sec_form)
    {
        $sec_form->delete();
    }
}
