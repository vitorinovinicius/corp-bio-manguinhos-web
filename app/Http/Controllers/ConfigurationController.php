<?php
/**
 * Created by PhpStorm.
 * User: CELTAPHP
 * Date: 07/11/2016
 * Time: 10:11
 */

namespace App\Http\Controllers;


use App\Models\Configuration;
use App\Repositories\ConfigurationRepository;
use App\Services\ConfigurationService;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{

    private $configurationRepository;
    /**
     * @var ConfigurationService
     */
    private $configurationService;

    /**
     * ConfigurationController constructor.
     * @param ConfigurationRepository $configurationRepository
     * @param ConfigurationService $configurationService
     */
    public function __construct(ConfigurationRepository $configurationRepository, ConfigurationService $configurationService)

    {
        $this->configurationRepository = $configurationRepository;
        $this->configurationService = $configurationService;
    }

    public function indexUnique(){

        $configuration = $this->configurationRepository->orderBy('contractor_id','asc')->all();

        return view('configuration.index', compact('configuration'));
    }

    public function storeUnique(Request $request){

        $configuration = $request->input('config');

        foreach($configuration as $key => $config_value){
           $this->configurationRepository->update(['config_value'=>$config_value],$key);
        }


        return redirect()->route('configuration.index')->with('message', 'Configurado com sucesso.');
    }

    public function index()
    {
        return $this->configurationService->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \App\Services\Response
     */
    public function create()
    {
        return $this->configurationService->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \App\Services\Response
     */
    public function store(Request $request)
    {
        return $this->configurationService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param Configuration $model
     * @return \App\Services\Response
     */
    public function show(Configuration $model)
    {
        return $this->configurationService->show($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Configuration $model
     * @return \App\Services\Response
     */
    public function edit(Configuration $model)
    {
        return $this->configurationService->edit($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Configuration $model
     * @return \App\Services\Response
     */
    public function update(Request $request,Configuration $model)
    {
        return $this->configurationService->update($model, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Configuration $model
     * @return \App\Services\Response
     */
    public function destroy(Configuration $model)
    {
        return $this->configurationService->destroy($model);
    }

}