<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Repositories\ConfigurationRepository;
use App\Repositories\ContractorRepository;
use Exception;

class ConfigurationService
{
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;
    /**
     * @var ContractorRepository
     */
    private $contractorRepository;

    /**
     * ConfigurationService constructor.
     * @param ConfigurationRepository $configurationRepository
     * @param ContractorRepository $contractorRepository
     */
    public function __construct(
        ConfigurationRepository $configurationRepository,
        ContractorRepository $contractorRepository
    )
    {
        $this->configurationRepository = $configurationRepository;
        $this->contractorRepository = $contractorRepository;
    }

    public function index()
    {
        $configurations = $this->configurationRepository->all();

        return view('configurations.index', compact('configurations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $contractors = $this->contractorRepository->all();
        return view('configurations.create', compact('contractors'));
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
            $this->configurationRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('configurations.index')->with('message', 'Item criado com sucesso.');
    }


    public function show($configuration)
    {
        return view('configurations.show', compact('configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($configuration)
    {
        return view('configurations.edit', compact('configuration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $configuration
     * @param Request $request
     * @return Response
     */
    public function update($configuration, $request)
    {
        $data = $request->all();

        try {
            $this->configurationRepository->update($data, $configuration->id);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('configurations.index')->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($configuration)
    {
        try {
            $configuration->delete();
        } catch (Exception $e) {
            return redirect()->route('configurations.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('configurations.index')->with('message', 'Item deletado com sucesso.');
    }
}