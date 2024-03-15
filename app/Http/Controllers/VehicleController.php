<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\ChecklistVehicleBasic;
use App\Models\Vehicle;
use App\Services\VehicleService;

class VehicleController extends Controller
{
    private $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function index()
    {
        return $this->vehicleService->listVehicle();
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(VehicleRequest $vehicle)
    {
        return $this->vehicleService->storeVehicle($vehicle);
    }

    public function  show(Vehicle $vehicle)    {

        return $this->vehicleService->showVehicle($vehicle);
    }

    public function edit(Vehicle $vehicle)
    {
        return $this->vehicleService->editVehicle($vehicle);
    }

    public function update(VehicleRequest $vehicleRequest, Vehicle $vehicle)
    {
        return $this->vehicleService->updateVehicle($vehicleRequest, $vehicle);
    }

    public function destroy(Vehicle $vehicle)
    {
        return $this->vehicleService->destroyVehicle($vehicle);
    }

    public function checklist()
    {
        return $this->vehicleService->checklist();
    }

    public function checklistShow(ChecklistVehicleBasic $checklistVehicleBasic)
    {
        return $this->vehicleService->checklistShow($checklistVehicleBasic);
    }

    public function checklistPdf(ChecklistVehicleBasic $checklistVehicleBasic)
    {
        return $this->vehicleService->checklistPdf($checklistVehicleBasic);
    }

}
