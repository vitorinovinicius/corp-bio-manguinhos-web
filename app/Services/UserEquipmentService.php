<?php


namespace App\Services;

use App\Criteria\UserEquipmentRemoveCriteriaCriteria;
use App\Criteria\UserEquipmentSelectCriteria;
use App\Repositories\EquipmentRepository;

class UserEquipmentService
{
    private $equipmentRepository;

    public function __construct(EquipmentRepository $equipmentRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
    }

    public function associate_equipment($operator)
    {
        $equipments = $this->equipmentRepository->pushCriteria(new UserEquipmentSelectCriteria())->all();
        return view('operators.equipments.associate_equipment', compact('operator', 'equipments'));
    }

    public function associate_equipment_store($user, $request, $flag)
    {
        
        $data = $request->all();
        $equipments = explode(",", $data['ids']);
        $error = [];
        
        try{
            foreach($equipments as $key=>$equipment){

                if($flag == 1){
                    $this->equipmentRepository->update(['user_id' => $user->id], $equipment);
                    $message_ok = "Itens associados com sucesso";
                }elseif($flag == 2){
                    $this->equipmentRepository->update(['user_id' => null], $equipment);
                    $message_ok = "Itens removidos com sucesso";
                }else{
                    $error[] = $equipment;
                }
            }
            if (count($error) > 0) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => 'Houve item que não pode ser associado, segue IDs (' . implode(", ", $error) . ')'
                ]);
            } else {
                return response()->json([
                    'retorno' => 1,
                    'mensagem' => $message_ok
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'retorno' => 2,
                'mensagem' => 'Houve um erro no processamento: '. $e->getMessage()
            ]);
        }
    }

    public function disassociate_equipment($operator)
    {
        $this->equipmentRepository->pushCriteria(new UserEquipmentRemoveCriteriaCriteria($operator->id));
        $equipments = $this->equipmentRepository->paginate(50);

        return view('operators.equipments.desassociate_equipment', compact('equipments','operator'));
    }
}