<?php 
namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Services\GroupService;

class GroupController extends Controller
{
    private $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index()
    {
        return $this->groupService->listGroups();
    }

    public function create()
    {
        return $this->groupService->createGroup();
    }

    public function store(Request $request)
    {
        return $this->groupService->storeGroup($request);
    }

    public function show(Group $group)
    {
        return $this->groupService->showGroup($group);
    }

    public function edit(Group $group)
    {
        return $this->groupService->editGroup($group);
    }

    public function update(Request $request, Group $group)
    {
        return $this->groupService->updateGroup($request, $group);
    }

    public function destroy(){}
}