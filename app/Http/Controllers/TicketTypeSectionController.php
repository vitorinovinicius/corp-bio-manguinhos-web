<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use App\Models\TicketTypeSection;
use App\Services\TicketTypeSectionService;
use Illuminate\Http\Request;

class TicketTypeSectionController extends Controller
{
    private $ticketTypeSectionService;

    public function __construct(TicketTypeSectionService $ticketTypeSectionService)
    {
        $this->ticketTypeSectionService = $ticketTypeSectionService;
    }

    public function create(TicketType $ticketType)
    {
        return $this->ticketTypeSectionService->createTicketTypeSection($ticketType);
    }

    public function store(Request $request)
    {
        return $this->ticketTypeSectionService->storeTicketTypeSection($request);
    }

    public function edit(TicketTypeSection $ticketTypeSection)
    {
        return $this->ticketTypeSectionService->editTicketTypeSection($ticketTypeSection);
    }

    public function update(TicketTypeSection $ticketTypeSection, Request $request)
    {
        return $this->ticketTypeSectionService->updateTicketTypeSection($ticketTypeSection, $request);
    }

    public function destroy(TicketTypeSection $ticketTypeSection)
    {
        return $this->ticketTypeSectionService->destroyTichetSection($ticketTypeSection);
    }

    public function ticketTypeSectionByTicketType($ticketTypeId)
    {
        return $this->ticketTypeSectionService->ticketTypeSectionByTicketType($ticketTypeId);
    }

}
