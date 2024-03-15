<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Criteria\ContractorDistrictSelectCriteria;
use App\Repositories\ContractorDistrictRepository;
use App\Repositories\ContractorRepository;
use App\Repositories\DistrictRepository;
use Exception;

class ContractorDistrictService
{
    /**
     * @var ContractorDistrictRepository
     */
    private $contractorDistrictRepository;
    /**
     * @var DistrictRepository
     */
    private $districtRepository;
    /**
     * @var ContractorRepository
     */
    private $contractorRepository;

    /**
     * ContractorDistrictService constructor.
     * @param ContractorDistrictRepository $contractorDistrictRepository
     * @param DistrictRepository $districtRepository
     * @param ContractorRepository $contractorRepository
     */
    public function __construct(
        ContractorDistrictRepository $contractorDistrictRepository,
        DistrictRepository $districtRepository,
        ContractorRepository $contractorRepository
    )
    {
        $this->contractorDistrictRepository = $contractorDistrictRepository;
        $this->districtRepository = $districtRepository;
        $this->contractorRepository = $contractorRepository;
    }

    public function index($request)
    {
        $this->contractorDistrictRepository->pushCriteria(new ContractorDistrictSelectCriteria());
        $contractor_districts = $this->contractorDistrictRepository->paginate();

        $districts = $this->districtRepository->all();
        $contractors = $this->contractorRepository->all();

        return view('contractor_districts.index', compact('contractor_districts','districts','contractors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $districts = $this->districtRepository->all();
        $contractors = $this->contractorRepository->all();
        return view('contractor_districts.create', compact('districts','contractors'));
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
            $this->contractorDistrictRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('contractor_districts.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($contractor_district)
    {
        return view('contractor_districts.show', compact('contractor_district'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($contractor_district)
    {
        $districts = $this->districtRepository->all();
        $contractors = $this->contractorRepository->all();

        return view('contractor_districts.edit', compact('contractor_district','districts','contractors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($contractor_district, $request)
    {
        $data = $request->all();

        try {
            $this->contractorDistrictRepository->update($data, $contractor_district->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('contractor_districts.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($contractorDistrict)
    {
        try {
            $contractorDistrict->delete();
        } catch (Exception $e) {
            return redirect()->route('contractor_districts.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('contractor_districts.index')->with('message', 'Item deletado com sucesso.');
    }
}