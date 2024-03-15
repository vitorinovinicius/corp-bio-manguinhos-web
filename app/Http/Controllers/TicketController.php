<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

use App\Services\TicketService;

class TicketController extends Controller
{
    /**
     * @var TicketService
     */
    private $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function dashboard()
    {
        return $this->ticketService->dashboard();
    }

    public function index()
    {
        return $this->ticketService->listTicket();
    }

    public function show(Ticket $ticket)
    {
        return $this->ticketService->showTicket($ticket);
    }

    public function create()
    {
        return $this->ticketService->createTicket();
    }

    public function addNewFormTicket(Request $request)
    {        
        return $this->ticketService->addNewFormTicket($request);
    }

    public function store(Request $request)
    {
        return $this->ticketService->addNewTicket($request);
    }

    public function update(){}

    public function edit(){}

    public function destroy(){}

    public function createOS(Ticket $ticket)
    {
        return $this->ticketService->createOS($ticket);
    }

    public function cancel(Ticket $ticket)
    {
        return $this->ticketService->cancel($ticket);
    }

    public function cancelUpdate(Ticket $ticket, Request $request)
    {
        return $this->ticketService->cancelUpdate($ticket, $request);
    }
}
