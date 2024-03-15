<?php

namespace App\Services;

use App\Repositories\GroupRepository;


class UserGroupService 
{
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {         
        $this->groupRepository = $groupRepository;
    }

    public function associateGroups($user)
    {
        $groups = $this->groupRepository->all();
        return view('users.groups.associate_groups', compact('groups', 'user'));
    }

    public function associateGroupsStore($user, $request)
    {
        $groupIds = $request['group_ids'];
        try{            
            foreach($groupIds as $groupId){
                $groupExist = $user->groups()->find($groupId);
                if($groupExist)
                    return redirect()->route('users.show', $user->uuid)->with('message', 'Grupo(s) já associado(s)');
                $user->groups()->attach($groupId);
            }
            return redirect()->route('users.show', $user->uuid)->with('message', 'Grupo(s) associado(s) com sucesso');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.');
        }        
    }

    public function disassociateGroups($user, $request)
    {
        
        $data = $request->all();
        $dataIds= $data["ids"];
        $groupIds = explode(",", $dataIds);
        $erro = array();

        try{

            foreach ($groupIds as $key => $value) {

                $remove = $user->groups()->detach($value);
                if ($remove) {
                    $mensagem_ok = "Itens removidos com sucesso";
                } else {
                    //Não há agendamento para essa ocorrência
                    $erro[] = $value;
                }
            }
            if (count($erro) > 0) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => 'Houve item que não pode ser removido, segue IDs (' . implode(", ", $erro) . ')'
                ]);
            } else {
                return response()->json([
                    'retorno' => 1,
                    'mensagem' => $mensagem_ok
                ]);
            }
        } catch (\Exception $exception){
            return response()->json([
                'retorno' => 2,
                'mensagem' => 'Houve um erro no processamento: '. $exception->getMessage()
            ]);
        }
    }

}