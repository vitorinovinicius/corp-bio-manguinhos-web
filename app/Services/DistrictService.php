<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Repositories\DistrictRepository;
use Exception;

class DistrictService
{
    /**
     * @var DistrictRepository
     */
    private $districtRepository;

    /**
     * DistrictService constructor.
     * @param DistrictRepository $districtRepository
     */
    public function __construct(
        DistrictRepository $districtRepository
    )
    {
        $this->districtRepository = $districtRepository;
    }

    public function index()
    {
        $districts = $this->districtRepository->paginate();

        return view('districts.index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('districts.create');
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
            $this->districtRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('districts.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($district)
    {
        return view('districts.show', compact('district'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($district)
    {
        return view('districts.edit', compact('district'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $district
     * @param Request $request
     * @return Response
     */
    public function update($district, $request)
    {
        $data = $request->all();

        try {
            $this->districtRepository->update($data, $district->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('districts.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($district)
    {
        try {
            $district->delete();
        } catch (Exception $e) {
            return redirect()->route('districts.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('districts.index')->with('message', 'Item deletado com sucesso.');
    }
}