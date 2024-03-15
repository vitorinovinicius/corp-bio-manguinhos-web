<?php

namespace App\Http\Controllers;

use App\Services\UserZoneService;
use App\Models\User;
use Illuminate\Http\Request;

class UserZoneController
{
    private $userZoneService;

    public function __construct(UserZoneService $userZoneService)
    {
        $this->userZoneService = $userZoneService;   
    }

    public function associate_zone(User $user)
    {
        return $this->userZoneService->associate_zone($user);
    }

    public function associate_zone_store(User $user, Request $request)
    {
        return $this->userZoneService->sync_zone_store($user, $request, $flag = 1);
    }

    public function disassociate_zone(User $user)
    {
        return $this->userZoneService->disassociate_zone($user);
    }

    public function disassociate_zone_store(User $user, Request $request)
    {
        return $this->userZoneService->sync_zone_store($user, $request, $flag = 2);
    }
}