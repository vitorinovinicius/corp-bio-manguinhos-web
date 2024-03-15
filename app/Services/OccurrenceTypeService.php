<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Criteria\Api\OccurrenceTypesContractorCriteria;
use App\Criteria\OccurrenceTypeFormsCriteria;
use App\Models\OccurrenceType;
use App\Repositories\FormRepository;
use App\Repositories\OccurrenceTypeFormRepository;
use App\Repositories\OccurrenceTypeRepository;
use Exception;

class OccurrenceTypeService
{
    /**
     * @var OccurrenceTypeRepository
     */
    private $occurrenceTypeRepository;
    /**
     * @var OccurrenceTypeFormRepository
     */
    private $occurrenceTypeFormRepository;
    /**
     * @var FormRepository
     */
    private $formRepository;

    /**
     * OccurrenceTypeService constructor.
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     */
    public function __construct(
        OccurrenceTypeFormRepository $occurrenceTypeFormRepository,
        FormRepository $formRepository,
        OccurrenceTypeRepository $occurrenceTypeRepository
    )
    {
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
        $this->occurrenceTypeFormRepository = $occurrenceTypeFormRepository;
        $this->formRepository = $formRepository;
    }

    public function index($request)
    {
        // $user = \Auth::user();
        $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypesContractorCriteria());
        $occurrence_types = $this->occurrenceTypeRepository->paginate();

        return view('occurrence_types.index', compact('occurrence_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (\Auth::user()->contractor_id) {
            $data['contractor_id'] = \Auth::user()->contractor_id;
        } else {
            return redirect()->route('occurrence_types.index')
                ->with('error', 'Você não pode cadastrar um Tipo de ocorrência.');
        }

        $this->formRepository->pushCriteria(new OccurrenceTypeFormsCriteria());
        $forms = $this->formRepository->findWhere(["status"=>1]);

        if ($forms->count() == 0) {
            return redirect()->route('occurrence_types.index')->with('error', 'Por favor crie/ative pelo menos um formulário antes de criar um tipo de serviço.');
        }

        return view('occurrence_types.create', compact('forms'));
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

        try {

            if (\Auth::user()->contractor_id) {
                $data['contractor_id'] = \Auth::user()->contractor_id;
            } else {
                return redirect()->route('occurrence_types.index')
                    ->with('error', 'Você não pode cadastrar um Tipo de ocorrência.');
            }

            $occurrence_type = $this->occurrenceTypeRepository->create($data);

            if (isset($data['form_id'])) {
                $occurrence_type->forms()->attach($data['form_id']);
            }

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: ' . $e->getMessage());
        }

        return redirect()->route('occurrence_types.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($occurrence_type)
    {
        return view('occurrence_types.show', compact('occurrence_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $occurrence_type
     * @return Response|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(OccurrenceType $occurrence_type)
    {

        $forms = $this->formRepository->findWhere(["contractor_id"=>$occurrence_type->contractor_id, "status"=>1])->all();
        $selectedForms = $occurrence_type->forms()->pluck('form_id')->toArray();

        return view('occurrence_types.edit', compact('occurrence_type',
            'selectedForms',
            'forms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $occurrence_type
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($request, OccurrenceType $occurrence_type)
    {
        $data = $request->all();

        try {

            $occurrence_type = $this->occurrenceTypeRepository->update($data, $occurrence_type->id);

            if(isset($data['form_id']) && !empty($data['form_id'])){
                $occurrence_type->forms()->detach();
                $occurrence_type->forms()->attach($data['form_id']);
            } else {
                $occurrence_type->forms()->detach();
            }

            return redirect()->route('occurrence_types.index')->with('message', 'Item atualizado com sucesso.');

        } catch (Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Erro ao tentar editar o item. <br>Erro: ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $occurrenceType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($occurrenceType)
    {
        try {
            $occurrenceType->delete();
        } catch (Exception $e) {
            return redirect()->route('occurrence_types.index')
                ->with('error', 'Erro ao tentar excluir o item. <br>Erro: ' . $e->getMessage());
        }
        return redirect()->route('occurrence_types.index')->with('message', 'Item deletado com sucesso.');
    }
}
