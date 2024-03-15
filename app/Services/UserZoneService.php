<?php

namespace App\Services;

use App\Criteria\UserZonesCriteria;
use App\Criteria\UserZonesRemoveCriteria;
use App\Repositories\ZoneRepository;

class UserZoneService
{
    private $zoneRepository;

    public function __construct(ZoneRepository $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function associate_zone($operator)
    {
        $zones = $this->zoneRepository->pushCriteria(new UserZonesCriteria($operator->id))->all();
        return view('operators.includes.associate_zones', compact('zones','operator'));
    }

    public function sync_zone_store($operator, $request, $flag = 1)
    {
        $data = $request->all();
        $zones_id = $data["ids"];
        $zones = explode(",", $zones_id);

        $erro = array();

        try{

            foreach ($zones as $key => $value) {

                $zone = $this->zoneRepository->findWhere(["id" => $value])->first();
                if ($zone) {
                    if ($flag == 1 || $flag == null) {
                        //Associa a equipe
                        $operator->zones()->attach($zone);
                        $mensagem_ok = "Itens associados com sucesso";
                    } elseif ($flag == 2) {
                        //Desassocia a equipe
                        $operator->zones()->detach($zone);
                        $mensagem_ok = "Itens removidos com sucesso";
                    }
                } else {
                    //Não há agendamento para essa ocorrência
                    $erro[] = $value;
                }
            }
            if (count($erro) > 0) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => 'Houve item que não pode ser associado, segue IDs (' . implode(", ", $erro) . ')'
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

    public function disassociate_zone($operator)
    {
        $this->zoneRepository->pushCriteria(new UserZonesRemoveCriteria($operator->id));
        $zones = $this->zoneRepository->paginate(50);

        return view('operators.includes.desassociate_zones', compact('zones','operator'));
    }
}