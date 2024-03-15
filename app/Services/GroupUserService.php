<?php

namespace App\Services;

use App\Criteria\UserClientSelectCriteria;
use App\Repositories\OccurrenceClientRepository;
use App\Repositories\UserRepository;


class GroupUserService 
{
    private $occurrenceClienteRepository;
    private $userRepository;

    public function __construct(OccurrenceClientRepository $ocurrenceClienteRepository, UserRepository $userRepository)
    {         
        $this->occurrenceClienteRepository = $ocurrenceClienteRepository;
        $this->userRepository = $userRepository;
    }

    public function associateUsers($group)
    {
        $userClients = $this->userRepository->pushCriteria(new UserClientSelectCriteria())->all();
        return view('groups.includes.associate_users', compact('group', 'userClients'));
    }

    public function associateUsersStore($group, $request)
    {
        $userIds = $request['user_id'];
        try{            
            foreach($userIds as $userId){
                $userExist = $group->users()->find($userId); 
                if($userExist)
                    return redirect()->route('groups.show', $group->uuid)->with('message', 'Usuário(s) já associado(s)');
                $group->users()->attach($userId);
            }
            return redirect()->route('groups.show', $group->uuid)->with('message', 'Usuário(s) associado(s) com sucesso');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.');
        }        
    }

    public function disassociateUsers($group, $request)
    {
        
        $data = $request->all();
        $dataIds= $data["ids"];
        $userIds = explode(",", $dataIds);
        $erro = array();

        try{

            foreach ($userIds as $key => $value) {

                $remove = $group->users()->detach($value);
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