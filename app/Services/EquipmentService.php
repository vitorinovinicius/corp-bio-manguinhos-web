<?php

namespace App\Services;

use App\Criteria\EquipmentCriteria;
use App\Criteria\OperatorSelectCriteria;
use App\Repositories\EquipmentRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class EquipmentService
{
    private $equipmentRepository;
    private $userRepository;

    public function __construct(EquipmentRepository $equipmentRepository, UserRepository $userRepository)
    {
        $this->equipmentRepository = $equipmentRepository;
        $this->userRepository = $userRepository;
    }

    public function listEquipments()
    {
        $equipments = $this->equipmentRepository->pushCriteria(new EquipmentCriteria())->all();
        return view('equipments.index', compact('equipments'));
    }

    public function storeEquipment($request)
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('equipments.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $data = $request->all();

        try {
            if(isset($data["validade_submit"]) && !empty($data["validade_submit"])){
                $data['validade'] = Carbon::createFromFormat('d/m/Y', $data["validade_submit"])->format("Y-m-d");
            }

            $this->equipmentRepository->create($data);

            return redirect()->route('equipments.index')->with('message', "Item criado com sucesso.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function showEquipment($equipment)
    {
        return view("equipments.show", compact('equipment'));
    }

    public function editEquipment($equipment)
    {
        $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();
        return view("equipments.edit", compact('equipment', 'operators'));
    }

    public function updateEquipment($request, $equipment)
    {
        $data = $request->all();
        if($data['user_id'] == "Não vinculado"){
            $data['user_id'] = NULL;
        }
        try{
            $this->equipmentRepository->update($data, $equipment->id);
            return redirect()->route('equipments.index')->with('message', 'Item atualizado com sucesso');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function destroyEquipment($equipment)
    {
        try{
            $this->equipmentRepository->delete($equipment->id);
            return redirect()->route('equipments.index')->with('message', 'Item excluído com sucesso.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Não foi possível executar a solicitação.<br>Erro: '.$e->getMessage());
        }
    }

    public function create()
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('equipments.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }
        $operators = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();

        return view('equipments.create',compact('operators'));
    }
}
