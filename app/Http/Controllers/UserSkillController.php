<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserSkillService;
use Illuminate\Http\Request;

class UserSkillController extends Controller
{
    /**
     * @var UserSkillService
     */
    private $userSkillService;

    /**
     * UserSkillController constructor.
     * @param UserSkillService $userSkillService
     */
    public function __construct(UserSkillService $userSkillService)
    {
        $this->userSkillService = $userSkillService;
    }

    public function associate_skill(User $user)
    {
        return $this->userSkillService->associate_skill($user);
    }

    public function associate_skill_store(User $user, Request $request)
    {
        return $this->userSkillService->sync_skill_store($user, $request, $flag = 1);
    }

    public function disassociate_skill(User $user)
    {
        return $this->userSkillService->disassociate_skill($user);
    }

    public function disassociate_skill_store(User $user, Request $request)
    {
        return $this->userSkillService->sync_skill_store($user, $request, $flag = 2);
    }
}
