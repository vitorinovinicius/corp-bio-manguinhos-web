<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChecklistVehicleIten;
use Illuminate\Http\Request;
use App\Services\ChecklistVehicleItenService;

class ChecklistVehicleItenController extends Controller
{
    private $checklistVechicleService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(ChecklistVehicleItenService $checklistVehicleItenService)
    {
        $this->checklistVechicleService = $checklistVehicleItenService;
    }

    public function index()
    {
        return $this->checklistVechicleService->listChecklistVechicleItens();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('checklist_vechicle_itens.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        return view('checklist_vehicle_item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->checklistVechicleService->storeChecklistVehicleItem($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $checklistVehicleIten
     * @return \Illuminate\Http\Response
     */
    public function show(ChecklistVehicleIten $checklistVehicleIten)
    {
        return $this->checklistVechicleService->showChecklistVehicleItem($checklistVehicleIten);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($checklistVehicleIten)
    {
        return view('checklist_vehicle_item.edit', compact('checklistVehicleIten'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->checklistVechicleService->updateChecklistVehicleItem($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->checklistVechicleService->deleteChecklistVehicleItem($id);

    }
}
