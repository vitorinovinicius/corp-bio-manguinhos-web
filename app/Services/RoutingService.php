<?php

namespace App\Services;

use App\Criteria\RoutingCriteria;
use App\Repositories\RoutingRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class RoutingService
{
   private $routingRepository;
   private $userRepository;

    public function __construct(RoutingRepository $routingRepository, UserRepository $userRepository)
    {
        $this->routingRepository = $routingRepository;
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $routings = $this->routingRepository->pushCriteria(new RoutingCriteria)->all();
        $operators = $this->userRepository->findWhere(["status" => 1]);

        return view('routings.index', compact('routings', 'operators'));
    }

    public function salveRouting($id = "", $aOccurrences, $steps, $type){
         //INSERT TABELA DE ROTEIRIZACAO
        
        $data['operator_id'] = $id;
        $data['routing_date'] = Carbon::now()->format('Y-m-d H:m:s');
        $data['addresses'] = json_encode($aOccurrences);
        $data['routed_addresses'] = json_encode($steps);
        $data['type'] = $type;
        $this->routingRepository->create($data);
    }
}
