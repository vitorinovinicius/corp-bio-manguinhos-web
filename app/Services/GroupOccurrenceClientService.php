<?php

namespace App\Services;

use App\Repositories\OccurrenceClientRepository;


class GroupOccurrenceClientService 
{
    private $occurrenceClienteRepository;

    public function __construct(OccurrenceClientRepository $ocurrenceClienteRepository)
    {
        $this->occurrenceClienteRepository = $ocurrenceClienteRepository;
    }

    public function associateClient($group)
    {
        return view('groups.includes.associate_clients', compact('group'));
    }

    public function associateClientStore($group, $request)
    {
        $occurrenceClientIds = $request['occurrence_client_id'];
        try{            
            foreach($occurrenceClientIds as $occurenceClientId){
                $this->occurrenceClienteRepository->update(['group_id' => $group->id], $occurenceClientId);    
            }
            return redirect()->route('groups.show', $group->uuid)->with('message', 'Cliente(s) associado(s) com sucesso');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.');
        }        
    }

    public function disassociateOccurrenceClients($group, $request)
    {
        
        $data = $request->all();
        $dataIds= $data["ids"];
        $occurrenceClientIds = explode(",", $dataIds);
        $erro = array();

        try{

            foreach ($occurrenceClientIds as $key => $value) {

                $occurrenceClient = $this->occurrenceClienteRepository->update(['group_id' => null], $value);
                if ($occurrenceClient) {
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