<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;

use App\Models\Setor;
use App\Criteria\Api\FormContractorCriteria;
use App\Repositories\FormRepository;
use App\Repositories\FormularioRepository;
use App\Repositories\OccurrenceTypeRepository;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Exception;

class FormularioService
{
    /**
     * @var FormRepository
     */
    private $formRepository;
    /**
     * @var FormularioRepository
     */
    private $formularioRepository;
    /**
     * @var OccurrenceTypeRepository
     */
    private $occurrenceTypeRepository;

    /**
     * FormService constructor.
     * @param FormRepository $formRepository
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     */
    public function __construct(
        FormularioRepository $formularioRepository,
        FormRepository $formRepository,
        OccurrenceTypeRepository $occurrenceTypeRepository
    )
    {
        $this->formularioRepository = $formularioRepository;
        $this->formRepository = $formRepository;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
    }

    public function index($request)
    {
        $user = \Auth::user();
        $this->formularioRepository->pushCriteria(new FormContractorCriteria($user));
        $forms = $this->formularioRepository->orderBy('id','asc')->paginate();

        return view('forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {

        // if (\Auth::user()->contractor_id) {
        //     $data['contractor_id'] = \Auth::user()->contractor_id;
        // } else {
        //     return redirect()->route('forms.index')
        //         ->with('error', 'Você não pode cadastrar um formulário.');
        // } 
        
        $teams = Setor::all();

        return view('forms.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($request)
    {
                
        $data = $request->all();

        $titulo = array(
            'setor_id' => $data['setor_id']??null,
            'descricao' => $data['titulo'],
            'limite_caracteres' => $data['limite_caracteres_titulo'],
            'ANO' => Carbon::now()            
        );         

        $form = $this->formularioRepository->create($titulo);

        // dd($form->id);
        // Verifica se o arquivo foi enviado
        if($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');    
            // Verifica se o arquivo é uma imagem válida
            if ($imagem->isValid()) {
                $path = public_path('imagens');
    
                // Verifica se o diretório de destino existe, se não, cria
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
    
                // Gera um nome único para a imagem
                $nomeImagem = $form->uuid.'.' . $imagem->getClientOriginalExtension();
    
                // Move o arquivo para o diretório desejado
                $imagem->move($path, $nomeImagem);
    
                // Salva a URL no banco de dados
                $url = asset('imagens/' . $nomeImagem);
                $this->formularioRepository->update(['imagem' => $url], $form->id);
            }
        }
        if(isset($data["sub_titulos"])){
            $subTituloArray = $data["sub_titulos"];
            foreach ($subTituloArray as $key => $value) {
                if (!empty($value)) {
                    $data2["sub_titulo_id"] = $form->id;
                    $data2["descricao"] = $value;
                    $data2["limite_caracteres"] = $data["limite_caracteres_subtitulo"][$key];
                    $data2["ANO"] = Carbon::now();
                    $this->formularioRepository->create($data2);
                }
            }
        }
        



        return redirect()->route('forms.index')
            ->with('message_form', 'Formulário criado com sucesso.');
    }


    public function show($form)
    {
        return view('forms.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $form
     * @return Response|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit($form)
    {
        return view('forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $form
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($form, $request)
    {
        $data = $request->all();

        try {
            $this->formRepository->update($data, $form->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('forms.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($form)
    {
        try {
            //Fazendo o recursivo

            // foreach ($form->form_groups as $form_group){
            //     foreach ($form_group->form_sections as $form_section){
            //         foreach ($form_section->form_fields as $form_field){
            //             $form_field->forceDelete();
            //         }
            //         $form_section->forceDelete();
            //     }
            //     $form_group->forceDelete();
            // }

            // //Associações de formulários a OSs e OTs
            // if($form->occurrence_type_forms){
            //     $occurrence_type_forms = $form->occurrence_type_forms;
            //     foreach ($occurrence_type_forms as $data){
            //         $data->forceDelete();
            //     }
            // }

            // //Fotos
            // if($form->occurrence_images){
            //     $occurrence_images = $form->occurrence_images;
            //     foreach ($occurrence_images as $data){
            //         $data->forceDelete();
            //     }
            // }

            $form->delete();
            return redirect()->route('forms.index')->with('message', 'Item deletado com sucesso.');

        } catch (Exception $e) {
            return redirect()->route('forms.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
    }
}
