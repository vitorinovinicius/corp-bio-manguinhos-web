<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\TicketType;
use Illuminate\Http\Request;
use App\Services\TicketTypeService;

class TicketTypeController extends Controller
{
    /**
     * @var TicketTypeService
     */
    private $ticketTypeService;

    public function __construct(TicketTypeService $ticketTypeService)
    {
        $this->ticketTypeService = $ticketTypeService;
    }
                     
    
    public function index(Group $group)
    {
        return $this->ticketTypeService->listTicketType($group);
    }

    public function show(TicketType $ticketType)
    {
        return $this->ticketTypeService->showTicketType($ticketType);
    }

    public function create(Group $group)
    {
        return $this->ticketTypeService->createTicketType($group);
    }

    public function store(Request $request)
    {
        return $this->ticketTypeService->addNewTicketType($request);
    }

    public function edit(TicketType $ticketType)
    {
        return $this->ticketTypeService->editTicketType($ticketType);
    }

    public function update(TicketType $ticketType, Request $request)
    {
        return $this->ticketTypeService->updateTicketType($ticketType, $request);
    }

    public function destroy(TicketType $ticketType)
    {
        return $this->ticketTypeService->destroyTicketType($ticketType);
    }

    public function listTicketTypeByGroup($groupId)
    {
        return $this->ticketTypeService->listTicketTypeByGroup($groupId);
    }

}
