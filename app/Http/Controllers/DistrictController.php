<?php
/**
 * Created by PhpStorm.
 * User: CELTAPHP
 * Date: 07/11/2016
 * Time: 10:11
 */

namespace App\Http\Controllers;


use App\Models\District;
use App\Repositories\DistrictRepository;
use App\Services\DistrictService;
use Illuminate\Http\Request;

class DistrictController
{

    private $districtRepository;
    /**
     * @var DistrictService
     */
    private $districtService;

    /**
     * DistrictController constructor.
     * @param DistrictRepository $districtRepository
     * @param DistrictService $districtService
     */
    public function __construct(DistrictRepository $districtRepository, DistrictService $districtService)

    {
        $this->districtRepository = $districtRepository;
        $this->districtService = $districtService;
    }

    public function indexUnique(){

        $district = $this->districtRepository->orderBy('contractor_id','asc')->all();

        return view('district.index', compact('district'));
    }

    public function storeUnique(Request $request){

        $district = $request->input('config');

        foreach($district as $key => $config_value){
           $this->districtRepository->update(['config_value'=>$config_value],$key);
        }


        return redirect()->route('district.index')->with('message', 'Configurado com sucesso.');
    }

    public function index()
    {
        return $this->districtService->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \App\Services\Response
     */
    public function create()
    {
        return $this->districtService->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \App\Services\Response
     */
    public function store(Request $request)
    {
        return $this->districtService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param District $model
     * @return \App\Services\Response
     */
    public function show(District $model)
    {
        return $this->districtService->show($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param District $model
     * @return \App\Services\Response
     */
    public function edit(District $model)
    {
        return $this->districtService->edit($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param District $model
     * @return \App\Services\Response
     */
    public function update(Request $request,District $model)
    {
        return $this->districtService->update($model, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param District $model
     * @return \App\Services\Response
     */
    public function destroy(District $model)
    {
        return $this->districtService->destroy($model);
    }

}