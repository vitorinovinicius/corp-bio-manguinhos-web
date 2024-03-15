<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    private $equipmentService;

    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    public function index()
    {
        return $this->equipmentService->listEquipments();
    }

    public function create()
    {
        return $this->equipmentService->create();
    }

    public function store(Request $request)
    {
        return $this->equipmentService->storeEquipment($request);
    }

    public function show(Equipment $equipment)
    {
        return $this->equipmentService->showEquipment($equipment);
    }

    public function edit(Equipment $equipment)
    {
        return $this->equipmentService->editEquipment($equipment);
    }

    public function update(Request $request, Equipment $equipment)
    {
        return $this->equipmentService->updateEquipment($request, $equipment);
    }

    public function destroy(Equipment $equipment)
    {
        return $this->equipmentService->destroyEquipment($equipment);
    }

}
