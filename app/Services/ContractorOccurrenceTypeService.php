<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Repositories\ContractorOccurrenceTypeRepository;
use App\Repositories\ContractorRepository;
use App\Repositories\OccurrenceTypeRepository;
use Exception;

class ContractorOccurrenceTypeService
{
    /**
     * @var ContractorOccurrenceTypeRepository
     */
    private $contractorOccurrenceTypeRepository;
    /**
     * @var ContractorRepository
     */
    private $contractorRepository;
    /**
     * @var OccurrenceTypeRepository
     */
    private $occurrenceTypeRepository;

    /**
     * ContractorOccurrenceTypeService constructor.
     * @param ContractorOccurrenceTypeRepository $contractorOccurrenceTypeRepository
     * @param ContractorRepository $contractorRepository
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     */
    public function __construct(
        ContractorOccurrenceTypeRepository $contractorOccurrenceTypeRepository,
        ContractorRepository $contractorRepository,
        OccurrenceTypeRepository $occurrenceTypeRepository
    )
    {
        $this->contractorOccurrenceTypeRepository = $contractorOccurrenceTypeRepository;
        $this->contractorRepository = $contractorRepository;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
    }

    public function index($request)
    {
        $contractor_occurrence_types = $this->contractorOccurrenceTypeRepository->paginate();

        $contractors = $this->contractorRepository->all();
        $occurrence_types = $this->occurrenceTypeRepository->all();


        return view('contractor_occurrence_types.index', compact('contractor_occurrence_types','contractors','occurrence_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $contractors = $this->contractorRepository->all();
        $occurrence_types = $this->occurrenceTypeRepository->all();

        return view('contractor_occurrence_types.create', compact('occurrence_types','contractors'));
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
            $this->contractorOccurrenceTypeRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('contractor_occurrence_types.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($contractor_occurrence_type)
    {
        return view('contractor_occurrence_types.show', compact('contractor_occurrence_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($contractor_occurrence_type)
    {
        $contractors = $this->contractorRepository->all();
        $occurrence_types = $this->occurrenceTypeRepository->all();

        return view('contractor_occurrence_types.edit', compact('contractor_occurrence_type','contractors','occurrence_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($contractor_occurrence_type, $request)
    {
        $data = $request->all();

        try {
            $this->contractorOccurrenceTypeRepository->update($data, $contractor_occurrence_type->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('contractor_occurrence_types.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($contractorOccurrenceType)
    {
        try {
            $contractorOccurrenceType->delete();
        } catch (Exception $e) {
            return redirect()->route('contractor_occurrence_types.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('contractor_occurrence_types.index')->with('message', 'Item deletado com sucesso.');
    }
}