<?php

namespace App\Services;

use App\Criteria\ChecklistVehicleCriteria;
use App\Models\ChecklistVehicleBasic;
use App\Repositories\ChecklistVehicle\ChecklistVehicleBasicRepository;
use App\Repositories\VehicleRepository;
use App\Criteria\VehicleCriteria;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Services\ArchiveService;


class VehicleService
{
    private $vehicleRepository;
    private $archiveService;
    /**
     * @var ChecklistVehicleBasicRepository
     */
    private $checklistVehicleBasicRepository;

    /**
     * VehicleService constructor.
     * @param VehicleRepository $vehicleRepository
     * @param \App\Services\ArchiveService $archiveService
     * @param ChecklistVehicleBasicRepository $checklistVehicleBasicRepository
     */
    public function __construct(
        VehicleRepository $vehicleRepository,
        ArchiveService $archiveService,
        ChecklistVehicleBasicRepository $checklistVehicleBasicRepository
    )
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->archiveService = $archiveService;
        $this->checklistVehicleBasicRepository = $checklistVehicleBasicRepository;
    }

    public function listVehicle()
    {

        $this->vehicleRepository->pushCriteria(new VehicleCriteria());
        $vehicles = $this->vehicleRepository->all();

        return view('vehicles.index', compact('vehicles'));
    }

    public function storeVehicle($vehicle)
    {
        $msg = '';

        $data = $vehicle->all();

        $vehicle = $this->vehicleRepository->create($data);

        $archives = \Request::file('archives');

        if ($archives) {
            $path = $vehicle->contractor_id   . "/veiculos/";
            $upload = $this->archiveService->create(1, $archives, $path, $vehicle->id);
        }

        return redirect()->route('vehicles.index')->with('message', "Item criado com sucesso.");
    }

    public function showVehicle($vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function editVehicle($vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function updateVehicle($vehicleRequest, $vehicle)
    {
        $data = $vehicleRequest->all();
        $this->vehicleRepository->update($data, $vehicle->id);

        $archives = \Request::file('archives');

        if ($archives) {
            $path = $vehicle->contractor_id   . "/veiculos/";
            $upload = $this->archiveService->create(1, $archives, $path, $vehicle->id);
        }

        return redirect()->route('vehicles.index')->with('message', 'Item atualizado com sucesso.');
    }

    public function destroyVehicle($vehicle)
    {
        // $vehicle = $this->vehicleRespository->findWhere(["id" => $vehicle->id]);

        // if($vehicle->count() > 0)
        //     return redirect()->route('vehicles.index')->with('error', 'O veículo não pode ser deletado');

        $this->vehicleRepository->delete($vehicle->id);

        return redirect()->route('vehicles.index')->with('message', 'Veículo excluído com sucesso.');
    }

    public function checklist()
    {

        $this->checklistVehicleBasicRepository->pushCriteria(new ChecklistVehicleCriteria());
        $checklist_vehicle_basics = $this->checklistVehicleBasicRepository->all();

        return view('vehicles.checklist', compact('checklist_vehicle_basics'));
    }

    public function checklistShow(ChecklistVehicleBasic $vehicleChecklistBasic)
    {
        return view('vehicles.show_checklist_vehicles', compact('vehicleChecklistBasic'));
    }

    public function checklistPdf($vehicleChecklistBasic)
    {
        return PDF::loadFile(str_replace('/admin/vehicles-checklist', '/vehicles-checklist', request()->url()))->inline($vehicleChecklistBasic->id . '.pdf');
    }
}
