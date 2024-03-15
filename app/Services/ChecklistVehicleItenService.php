<?php

namespace App\Services;

use App\Repositories\ChecklistVehicle\ChecklistVehicleItemRepository;
use App\Criteria\ChecklistVehicleItemCriteria;

class ChecklistVehicleItenService
{
    private $checklistVehicleItemRepository;
    private $checklistVehicleItemCriteria;

    public function __construct(
        ChecklistVehicleItemRepository $checklistVehicleItemRepository
    )
    {
        $this->checklistVehicleItemRepository = $checklistVehicleItemRepository;

    }

    public function listChecklistVechicleItens()
    {

        $this->checklistVehicleItemRepository->pushCriteria(new ChecklistVehicleItemCriteria());

        $checklistVehicleItens = $this->checklistVehicleItemRepository->all();

        return view('checklist_vehicle_item.index', compact('checklistVehicleItens'));
    }

    public function showChecklistVehicleItem($checklistVehicleIten)
    {
        return view('checklist_vehicle_item.show', compact('checklistVehicleIten'));
    }

    public function storeChecklistVehicleItem($request)
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('checklist_vechicle_itens.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $dados = $request->all();
        $dados['contractor_id'] = \Auth::user()->contractor_id;
        $item = $this->checklistVehicleItemRepository->create($dados);

        if ($item) {
            return redirect()->route('checklist_vechicle_itens.index')->with('message', "Item criado com sucesso.");
        }

    }

    public function updateChecklistVehicleItem($request, $checklistVehicleIten)
    {
        $dados = $request->all();

        $item = $this->checklistVehicleItemRepository->update($dados, $checklistVehicleIten->id);

        if ($item) {
            return redirect()->route('checklist_vechicle_itens.index')->with('message', "Item alterado com sucesso.");
        }

    }

    public function deleteChecklistVehicleItem($checklistVehicleIten)
    {
        $this->checklistVehicleItemRepository->delete($checklistVehicleIten->id);

        return redirect()->route('checklist_vechicle_itens.index')->with('message', 'Item excluído com sucesso.');
    }

}
