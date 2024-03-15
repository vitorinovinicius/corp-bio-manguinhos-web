<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\GroupOccurrenceClientService;
use Illuminate\Http\Request;

class GroupOccurrenceClientController extends Controller
{
    /**
     * @var GroupOccurrenceClientService
     */
    private $groupOccurrenceClientService;

    public function __construct(GroupOccurrenceClientService $groupOccurrenceClientService)
    {
        $this->groupOccurrenceClientService = $groupOccurrenceClientService;
    }

    public function associateOccurrenceClients(Group $group)
    {
        return $this->groupOccurrenceClientService->associateClient($group);
    }

    public function associateOccurrenceClientStore(Group $group, Request $request)
    {
        return $this->groupOccurrenceClientService->associateClientStore($group, $request);
    }

    public function disassociateOccurrenceClients(Group $group, Request $request)
    {
        return $this->groupOccurrenceClientService->disassociateOccurrenceClients($group, $request);
    }
}
