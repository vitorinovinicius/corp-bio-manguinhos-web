<?php

namespace App\Services;

use App\Models\Setor;
use App\Criteria\EnvioEmailCriteria;
use App\Repositories\FormRepository;
use App\Repositories\FormularioRepository;
use App\Repositories\SecaoFormularioRepository;
use App\Repositories\RelatorioRepository;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Exception;

Class SecaoFormularioService
{
    /**
     * @var SecaoFormularioRepository
     */
    private $secaoFormularioRepository;
    /**
     * @var FormularioRepository
     */
    private $formularioRepository;
    /**
     * @var RelatorioRepository
     */
    private $relatorioRepository;

    /**
     * FormService constructor.
     * @param SecaoFormularioRepository $secaoFormularioRepository
     * @param FormularioRepository $formularioRepository
     * @param RelatorioRepository $relatorioRepository
     */
    public function __construct(
        SecaoFormularioRepository $secaoFormularioRepository,
        FormularioRepository $formularioRepository,
        RelatorioRepository $relatorioRepository
    )
    {
        $this->secaoFormularioRepository = $secaoFormularioRepository;
        $this->formularioRepository = $formularioRepository;
        $this->relatorioRepository = $relatorioRepository;
    }
    public function store($request)
    {
        $data = $request->all();
        $data['descricao'] = $data['descricao'];

        try {
            
            $this->secaoFormularioRepository->create($data);
    
            return response()->json([
                'message' => 'Seção salva com sucesso!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Falha ao salvar seção!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function consulta_ajax($secaoFormulario)
    {
        $secoes = $secaoFormulario->secoes;
        $data_secoes = array();
        foreach ($secoes as $secao){
            $data_secoes[] = [
                'secao_id' => $secao->id,
                'setor_nome' => $secao->setor()->where('id', $secao->setor_id)->pluck('name')->first()?:'',
                'usuario_nome' => $secao->usuario()->where('id', $secao->user_id)->pluck('name')->first()?:'',
                'descricao' => $secao->descricao?:'',
                'texto' => $secao->texto?:'',
                'limite_caracteres' => $secao->limite_caracteres?:'',
                'status' => $secao->status(), //0 - Pendente, 1 - Em andamento, 2 - analisando, 3 - Em correção, 4 - Concluído
            ];
        }

        return response()->json([
            'secoes' => $data_secoes
        ], 200);
    }

    public function envioEmail(){
        $this->secaoFormularioRepository->pushCriteria(new EnvioEmailCriteria());
        $secoes = $this->secaoFormularioRepository->get();
        
        foreach ($secoes as $secao){
            

        }
    }
}