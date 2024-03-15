<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserGroupService;

class UserGroupController extends Controller
{
    /**
     * @var UserGroupService
     */
    private $userGroupService;

    public function __construct(UserGroupService $userGroupService)
    {
        $this->userGroupService = $userGroupService;
    }

    public function associateGroups(User $user)
    {
        return $this->userGroupService->associateGroups($user);
    }

    public function associateGroupStore(User $user, Request $request)
    {
        return $this->userGroupService->associateGroupsStore($user, $request);
    }

    public function disassociateGroups(User $user, Request $request)
    {
        return $this->userGroupService->disassociateGroups($user, $request);
    }
}
