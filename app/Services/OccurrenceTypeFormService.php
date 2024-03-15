<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Criteria\OccurrenceTypeFormSearchCriteria;
use App\Models\OccurrenceTypeForm;
use App\Repositories\FormRepository;
use App\Repositories\OccurrenceTypeFormRepository;
use App\Repositories\OccurrenceTypeRepository;
use Exception;

class OccurrenceTypeFormService
{
    /**
     * @var OccurrenceTypeFormRepository
     */
    private $occurrenceTypeFormRepository;
    /**
     * @var FormRepository
     */
    private $formRepository;
    /**
     * @var OccurrenceTypeRepository
     */
    private $occurrenceTypeRepository;


    /**
     * OccurrenceTypeFormService constructor.
     * @param OccurrenceTypeFormRepository $occurrenceTypeFormRepository
     * @param FormRepository $formRepository
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     */
    public function __construct(
        OccurrenceTypeFormRepository $occurrenceTypeFormRepository,
        FormRepository $formRepository,
        OccurrenceTypeRepository $occurrenceTypeRepository
    )
    {
        $this->occurrenceTypeFormRepository = $occurrenceTypeFormRepository;
        $this->formRepository = $formRepository;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
    }

    public function index($request)
    {

        $this->occurrenceTypeFormRepository->pushCriteria(new OccurrenceTypeFormSearchCriteria());
        $occurrence_type_forms = $this->occurrenceTypeFormRepository->paginate();

        $forms = $this->formRepository->all();
        $occurrence_types = $this->occurrenceTypeRepository->all();

        return view('occurrence_type_forms.index', compact('occurrence_type_forms','forms','occurrence_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $forms = $this->formRepository->findWhere(['status' => 1]);
        $occurrence_types = $this->occurrenceTypeRepository->findWhere(['status' => 1]);
        return view('occurrence_type_forms.create', compact('forms', 'occurrence_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($request)
    {
        $data = $request->all();
        try {
            $this->occurrenceTypeFormRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: ' . $e->getMessage());
        }

        return redirect()->route('occurrence_type_forms.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($occurrence_type_form)
    {
        return view('occurrence_type_forms.show', compact('occurrence_type_form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($occurrence_type_form)
    {
        $forms = $this->formRepository->findWhere(['status' => 1]);
        $occurrence_types = $this->occurrenceTypeRepository->findWhere(['status' => 1]);
        return view('occurrence_type_forms.edit', compact('occurrence_type_form', 'forms', 'occurrence_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function update($occurrence_type_form, $request)
    {
        $data = $request->all();

        try {
            $this->occurrenceTypeFormRepository->update($data, $occurrence_type_form->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: ' . $e->getMessage());
        }

        return redirect()->route('occurrence_type_forms.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($occurrenceTypeForm)
    {
        try {
            $occurrenceTypeForm->delete();
        } catch (Exception $e) {
            return redirect()->route('occurrence_type_forms.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: ' . $e->getMessage());
        }
        return redirect()->back()->withInput()->with('message', 'Item deletado com sucesso.');
    }

    public function atualizaManual()
    {

        $generals = [
            [
                'occurrence_type_id' => 4,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 4,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 4,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 4,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 31,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 31,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 38,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 38,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 4,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 4,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 28,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 28,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 4,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 4,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 4,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 4,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 4,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 4,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 4,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 4,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 25,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 25,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 28,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 28,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 41,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 41,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 5,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 17,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 17,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 17,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 17,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 17,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 18,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 18,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 39,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 39,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 42,
                'form_id' => 2,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 17,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 17,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 35,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 35,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 21,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 30,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 17,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 22,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 22,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 34,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 34,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 37,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 37,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 40,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 40,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 27,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 27,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 40,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 40,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 34,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 34,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 37,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 37,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 19,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 19,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 20,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 20,
                'form_id' => 1,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 36,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 39,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 39,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 29,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 23,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 23,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 28,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 28,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 24,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 24,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 24,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 24,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 26,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 26,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 32,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 33,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 11,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 28,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 28,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 46,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 46,
                'form_id' => 2,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 43,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 44,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 45,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 15,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 1,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 2,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 3,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 6,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 7,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 8,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                
                'occurrence_type_id' => 9,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 10,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 10,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 13,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 13,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 12,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 12,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 14,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 16,
                'form_id' => 5,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 16,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 30,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 30,
                'form_id' => 4,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 29,
                'form_id' => 3,
                'is_required' => 1,

            ],
            [
                'occurrence_type_id' => 29,
                'form_id' => 4,
                'is_required' => 1,

            ],
        ];

        try {
            foreach ($generals as $general) {
                OccurrenceTypeForm::where("occurrence_type_id", $general["occurrence_type_id"])
                    ->where("form_id", $general["form_id"])
                    ->update(["is_required" => $general["is_required"]]);
            }
        } catch (Exception $e) {
            dump($e->getMessage());
        }

        return "Atualização feita";
    }
}