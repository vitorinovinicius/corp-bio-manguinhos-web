<?php

    namespace App\Services;

    use App\Repositories\OccurrenceOrderRepository;
    use Carbon\Carbon;
    use App\Repositories\OccurrenceRepository;
    use App\Repositories\UserRepository;
    use App\Services\RoutingService;
    use App\Repositories\OccurrenceClientRepository;

    class OccurrenceOrderService
    {
        private $occurrenceOrderRepository;
        private $occurrenceRepository;
        private $userRepository;
        private $occurrenceClientRepository;
        private $routingService;

        private $id;

        public function __construct(OccurrenceOrderRepository $occurrenceOrderRepository, OccurrenceRepository $occurrenceRepository, UserRepository $userRepository, OccurrenceClientRepository $occurrenceClientRepository, RoutingService $routingService)
        {
            $this->occurrenceOrderRepository = $occurrenceOrderRepository;
            $this->occurrenceRepository = $occurrenceRepository;
            $this->userRepository = $userRepository;
            $this->occurrenceClientRepository = $occurrenceClientRepository;
            $this->routingService = $routingService;
        }

        public function order($request)
        {
            $aOrder = $request->all();
            $order_app = 0;

            $this->addOrderFlag($aOrder['operator'], $order_app);
            try {
                foreach ($aOrder['ordem_atual'] as $order => $occurence) {

                    $data['order_client'] = $order;
                    $this->occurrenceRepository->update($data, $occurence);
                }
            } catch (\Exception $e) {
                return false;
            }

        }

        /**
         * route
         * Recebe o ID do técnico e realiza busca das os
         * agendadas para a dia corrente
         *
         * @param mixed $id
         * @return void
         */
        public function route($id)
        {
            $this->id = $id;

            $occurrences = $this->occurrenceRepository->scopeQuery(function ($query) {

                return $query->orderBy('order_client', 'asc')->where([
                    'operator_id' => $this->id,
                    'status' => 1,
                    'schedule_date' => Carbon::now()->format("Y-m-d")
                ]);
            })->all();

            $operator = $this->userRepository->find($id);

            //startPoint
            if ($operator->operator_start_point) {
                if (!empty($operator->operator_start_lat) && !empty($operator->operator_start_lng)) {
                    $startPoint = [
                        'lat' => $operator->operator_start_lat,
                        'lng' => $operator->operator_start_lng
                    ];
                } else {
                    $startPoint = getCoordsAddressGMAPS($operator->operator_start_point);
                    $this->routingService->salveRouting(null, [['address' => $operator->operator_start_point]], [$startPoint], 2);
                }
            } else {
                if ($operator->contractor->lat && $operator->contractor->lng) {
                    $startPoint = [
                        'lat' => $operator->contractor->lat,
                        'lng' => $operator->contractor->lng
                    ];
                } else {
                    $startPoint = getCoordsAddressGMAPS($operator->contractor->address);
                    $this->routingService->salveRouting(null, [['address' => $operator->contractor->address]], [$startPoint], 2);
                }
            }

            //arrivalPoint
            if ($operator->operator_arrival_point) {
                if (!empty($operator->operator_arrival_lat) && !empty($operator->operator_arrival_lng)) {
                    $arrivalPoint = [
                        'lat' => $operator->operator_arrival_lat,
                        'lng' => $operator->operator_arrival_lng
                    ];
                } else {
                    $arrivalPoint = getCoordsAddressGMAPS($operator->operator_start_point);
                    $this->routingService->salveRouting(null, [['address' => $operator->operator_arrival_point]], [$startPoint], 2);
                }
            } else {
                if (!empty($operator->contractor->lat) && !empty($operator->contractor->lng)) {
                    $arrivalPoint = [
                        'lat' => $operator->contractor->lat,
                        'lng' => $operator->contractor->lng
                    ];
                } else {
                    $arrivalPoint = getCoordsAddressGMAPS($operator->contractor->address);
                    $this->routingService->salveRouting(null, [['address' => $operator->contractor->address]], [$arrivalPoint], 2);
                }
            }

            $dataPoints[] = $startPoint; //inicia o array com de
            $aOccurrences = [];

            foreach ($occurrences as $occurrence) {
                //percorre cada OS e recupera os endereços de atendimento e chama função para retorno das coordernadas
                $dataClient = $occurrence->occurrence_client;
                $address = trim($dataClient->address) . ", $dataClient->number " . trim($dataClient->district) . " " . trim($dataClient->city) . " " . $dataClient->uf;
                if ($dataClient->lat != "" && $dataClient->lng != "") {
                    $points = [
                        'lat' => $dataClient->lat,
                        'lng' => $dataClient->lng
                    ];
                } else {
                    $points = getCoordsAddressGMAPS($address);
                    $this->routingService->salveRouting(null, [['address' => $address]], [$points], 2);
                    $data['lat'] = $points['lat'];
                    $data['lng'] = $points['lng'];
                    $this->occurrenceClientRepository->update($data, $dataClient->id);
                }

                $dataPoints[] = $points;

                //gera um array de ID e points das OS
                $aOccurrences[] = [
                    'id' => $occurrence->id,
                    'address' => $address,
                    'points' => $points
                ];
            }

            $dataPoints[] = $arrivalPoint; //ponto de chegada

            $waypoint = [];
            $arrayWaypoints = [];

            //foreach(array_filter($dataPoints) as $point){
            foreach ($dataPoints as $point) {
                if (isset($point['lat']) && isset($point['lng'])) {
                    $waypoint = [
                        "latitude" => $point['lat'],
                        "longitude" => $point['lng']
                    ];

                    $arrayWaypoints[] = $waypoint;
                }
            }

            $waypoints = "";

            foreach (array_filter($arrayWaypoints) as $waypoint) {
                $waypoints .= ($waypoints == "") ? $waypoint['latitude'] . "," . $waypoint['longitude'] : ":" . $waypoint['latitude'] . "," . $waypoint['longitude'];
            }

            //FAZ A SOLICITAÇÃO DE ROTA PARA A TOMTOM
            $jsonResult = calculateDirectionsTomTom($waypoints);


            if (!isset($jsonResult["routes"]) || !isset($jsonResult["optimizedWaypoints"])) {
                return false;
            }

            // $routeNode     = $jsonResult['routes'][0]; // primeira posicao do array de rotas
            // $legs          = $routeNode["legs"];
            $optimizedWaypoints = $jsonResult['optimizedWaypoints']; // ordem das steps


            $steps = [];

            //Quando não tem ponto de partida ele pega a primeira OS como
            if ($startPoint == '') {
                $steps[] = $aOccurrences[0];
            }

            foreach ($optimizedWaypoints as $ow) {
                // obtem a step enviada
                $steps[] = ($startPoint == '') ? $aOccurrences[$ow["optimizedIndex"] + 1] : $aOccurrences[$ow["optimizedIndex"]];
                // $leg = $legs[$ow["providedIndex"]];
            }

            if ($arrivalPoint == '') {
                $steps[] = end($aOccurrences);
            }

            //Persiste dos dados na tabela
            $this->routingService->salveRouting($id, $aOccurrences, $steps, 1);
            $this->addOrderFlag($id, 0);
            $this->updateOrder($steps);


        }

        public function addOrderFlag($operator_id, $order_app)
        {
            $ocuurrenceOrder = $this->occurrenceOrderRepository->scopeQuery(function ($query) {
                return $query->limit(1)->orderBy('flag', 'desc');
            })->findWhere([
                'operator_id' => $operator_id,
                'flag_date' => Carbon::today()
            ]);

            if ($ocuurrenceOrder->isEmpty()) {
                $this->occurrenceOrderRepository->create([
                    'operator_id' => $operator_id,
                    'flag' => 1,
                    'order_app' => $order_app,
                    'flag_date' => Carbon::today()
                ]);
            } else {
                $arrayOrder = array(
                    "flag" => $ocuurrenceOrder[0]->flag + 1,
                    "order_app" => $order_app,
                );
                $this->occurrenceOrderRepository->update($arrayOrder, $ocuurrenceOrder[0]->id);
            }

        }

        private function updateOrder($steps)
        {
            try {
                foreach ($steps as $order => $occurrence) {

                    $data['order_client'] = $order;
                    $this->occurrenceRepository->update($data, $occurrence['id']);
                }

            } catch (\Exception $e) {
                return false;
            }
        }
    }
