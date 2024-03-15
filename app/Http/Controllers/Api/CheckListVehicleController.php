<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\CheckListVehicleService;
use Illuminate\Http\Request;

class CheckListVehicleController extends Controller
{
    /**
     * @var CheckListVehicleService
     */
    private $checkListVehicleService;

    public function __construct(CheckListVehicleService $checkListVehicleService)
    {
        $this->checkListVehicleService = $checkListVehicleService;
    }

    public function check(){
        return $this->checkListVehicleService->check();
    }

    public function store(Request $request){
        return $this->checkListVehicleService->store($request);
    }

    public function storeImage(Request $request){
        return $this->checkListVehicleService->storeImage($request);
    }
}
