<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\GroupUserService;
use Illuminate\Http\Request;

class GroupUserController extends Controller
{
    /**
     * @var GroupUserService
     */
    private $groupUserService;

    public function __construct(GroupUserService $groupUserService)
    {
        $this->groupUserService = $groupUserService;
    }

    public function associateUsers(Group $group)
    {
        return $this->groupUserService->associateUsers($group);
    }

    public function associateUserStore(Group $group, Request $request)
    {
        return $this->groupUserService->associateUsersStore($group, $request);
    }

    public function disassociateUsers(Group $group, Request $request)
    {
        return $this->groupUserService->disassociateUsers($group, $request);
    }
}
