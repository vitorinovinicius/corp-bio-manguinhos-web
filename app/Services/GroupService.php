<?php

namespace App\Services;

use App\Criteria\UserClientSelectCriteria;
use App\Repositories\ContractorRepository;
use App\Repositories\GroupRepository;
use App\Repositories\OccurrenceClientRepository;
use App\Repositories\UserRepository;

class GroupService
{
    private $groupRepository;
    private $contractorRepository;
    private $occurrenceClientRepository;
    private $userRepository;

    public function __construct(GroupRepository $groupRepository, ContractorRepository $contractorRepository, OccurrenceClientRepository $occurrenceClientRepository, UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->contractorRepository = $contractorRepository;
        $this->occurrenceClientRepository = $occurrenceClientRepository;
        $this->userRepository = $userRepository;
    }

    public function listGroups()
    {
        $groups = $this->groupRepository->all();
        return view('groups/index', compact('groups'));
    }

    public function createGroup()
    {

        $userClients = $this->userRepository->pushCriteria(new UserClientSelectCriteria())->all();

        return view('groups/create', compact('userClients'));
    }

    public function storeGroup($request)
    {
        $data = $request->all();
        $contractor_id = \Auth::user()->contractor_id;
            if (!$contractor_id) {
                return redirect()->route('groups.index')->with('error', 'Empreiteira não encontrada');
            }
        try{
            $this->groupRepository->create($data);
            return redirect()->route('groups.index')->with('message', 'Item criado com sucesso.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function showGroup($group)
    {
        $ticketTypes = $group->ticketType;
        return view('groups.show', compact('group', 'ticketTypes'));
    }

    public function editGroup($group)
    {
        $contractors = $this->contractorRepository->all();
        $occurrence_clients = $this->occurrenceClientRepository->all();
        return view('groups.edit', compact('group', 'contractors', 'occurrence_clients'));
    }

    public function updateGroup($request, $group)
    {
        $data = $request->all();
        try{
            $this->groupRepository->update($data, $group->id);
            return redirect()->route('groups.index')->with('message', 'Item atualuizado com sucesso.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function destroyGroup(){}

}
