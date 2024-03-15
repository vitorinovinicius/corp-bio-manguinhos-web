<?php

namespace App\Services;

use App\Repositories\ZoneRepository;

class ZoneService {

    private $zoneRepository;

    public function __construct(ZoneRepository $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function listZone(){
        $zones = $this->zoneRepository->all();
        return view('zones.index', compact('zones'));
    }

    public function createZone()
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('zones.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        return view('zones.create');
    }

    public function storeZone($request)
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('zones.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $data = $request->all();

        try{
            $this->zoneRepository->create($data);
        }catch(\Exception $e){
            return redirect()->route('zones.index')->with('error', 'Não foi possível cadastrar zona');
        }

        return redirect()->route('zones.index')->with('message', 'Zona cadastrada com sucesso.');
    }

    public function showZone($zone)
    {
        return view('zones.show', compact('zone'));
    }

    public function editZone($zone)
    {
        return view('zones.edit', compact('zone'));
    }

    public function updateZone($request, $zone)
    {
        $data = $request->all();

        try{
            $this->zoneRepository->update($data, $zone->id);
        }catch(\Exception $e){
            return redirect()->route('zones.index')->with('error', 'Não foi possível atualizar zona');
        }

        return redirect()->route('zones.index')->with('message', 'Zona atualizada com sucesso.');

    }

    public function destroyZone($zone)
    {
        if($zone->occurrenceClients->count() || $zone->users->count()){
            return redirect()->route('zones.index')->with('error', 'Não foi possível excluir zona, ela está associada à algum cliente ou técnico');
        }

        try{
            $this->zoneRepository->delete($zone->id);
        }catch(\Exception $e){
            return redirect()->route('zones.index')->with('error', 'Não foi possível excluir zona');
        }

        return redirect()->route('zones.index')->with('message', 'Zona excluída com sucesso.');
    }

}
