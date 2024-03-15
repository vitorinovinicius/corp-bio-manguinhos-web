<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserEquipmentService;
use App\Models\User;

class UserEquipmentController extends Controller
{
    private $userEquipmentService;

    public function __construct(UserEquipmentService $userEquipmentService)
    {
        $this->userEquipmentService = $userEquipmentService;
    }

    public function associate_equipment(User $user)
    {
        return $this->userEquipmentService->associate_equipment($user);
    }

    public function associate_equipment_store(User $user, Request $request)
    {
        return $this->userEquipmentService->associate_equipment_store($user, $request, $flag = 1);
    }

    public function disassociate_equipment(User $user)
    {
        return $this->userEquipmentService->disassociate_equipment($user);
    }

    public function disassociate_equipment_store(User $user, Request $request)
    {
        
        return $this->userEquipmentService->associate_equipment_store($user, $request, $flag = 2);
    }
}
