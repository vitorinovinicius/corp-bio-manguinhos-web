<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Services\ZoneService;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    private $zoneService;

    public function __construct(ZoneService $zoneService)
    {
        $this->zoneService = $zoneService;   
    }

    public function index()
    {
       return $this->zoneService->listZone();
    }

    public function create()
    {
        return $this->zoneService->createZone();
    }

    public function store(Request $request)
    {
        return $this->zoneService->storeZone($request);
    }

    public function show(Zone $zone)
    {
        return $this->zoneService->showZone($zone);
    }

    public function edit(Zone $zone)
    {
        return $this->zoneService->editZone($zone);
    }

    public function update(Request $request, Zone $zone)
    {
        return $this->zoneService->updateZone($request, $zone);
    }

    public function destroy(Zone $zone)
    {
        return $this->zoneService->destroyZone($zone);
    }
}