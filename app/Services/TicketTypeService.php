<?php

namespace App\Services;

use App\Repositories\TicketTypeRepository;

class TicketTypeService
{
    /**
     * @var TicketTypeRepository
     */
    private $ticketTypeRepository;


    public function __construct(TicketTypeRepository $ticketTypeRepository)
    {
        $this->ticketTypeRepository = $ticketTypeRepository;

    }

    public function listTicketType($group)
    {

    }

    public function showTicketType($ticketType)
    {
        return view('ticket_types.show', compact('ticketType'));
    }

    public function createTicketType($group)
    {
        return view('ticket_types.create', compact('group'));
    }

    public function addNewTicketType($request)
    {
        $data = $request->all();
        $group = json_decode($data['group']);
        $data['group_id'] = $group->id;
        try{
            $this->ticketTypeRepository->create($data);
            return redirect()->route('groups.show', $group->uuid)->with('message', 'Tipo ticket criado com sucesso.');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function editTicketType($ticketType)
    {
        return view('ticket_types.edit',compact('ticketType') );
    }

    public function updateTicketType($ticketType, $request)
    {
        $data = $request->all();
        try{
            $this->ticketTypeRepository->update($data, $ticketType->id);
            return redirect()->route('groups.show', $ticketType->group->uuid)->with('message', 'Tipo ticket atualizado com sucesso.');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function destroyTicketType($ticketType)
    {
        try{
            $ticketType->delete();
            return redirect()->route('groups.show', $ticketType->group->uuid)->with('message', 'Tipo ticket atualizado com sucesso.');
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação. Remova as seções e tente novamente');
        }
    }

    public function listTicketTypeByGroup($groupId)
    {
        return $this->ticketTypeRepository->findWhere(['group_id'=>$groupId]);
    }

}
