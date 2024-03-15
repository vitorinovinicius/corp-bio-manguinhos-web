<?php
    /**
     * Created by PhpStorm.
     * User: CELTAPHP
     * Date: 17/11/2016
     * Time: 13:58
     */

    namespace App\Services;

    use App\Criteria\OccurrenceClientSelectCriteria;
    use App\Repositories\OccurrenceClientRepository;
    use App\Repositories\OccurrenceClientPhoneRepository;
    use App\Repositories\OccurrenceRepository;
    use App\Http\Resources\Api\ClientFullResource;
    use App\Models\OccurrenceClient;
    use App\Services\RoutingService;

    class OccurrenceClientService
    {
        private $occurrenceClientRepository;
        private $occurrenceClientSelectCriteria;
        private $occurrenceRepository;
        private $occurrenceClientPhoneRepository;
        private $routingService;

        public function __construct(OccurrenceClientRepository $occurrenceClientRepository, OccurrenceClientSelectCriteria $occurrenceClientSelectCriteria, OccurrenceRepository $occurrenceRepository, OccurrenceClientPhoneRepository $occurrenceClientPhoneRepository, RoutingService $routingService)
        {
            $this->occurrenceClientRepository = $occurrenceClientRepository;
            $this->occurrenceClientSelectCriteria = $occurrenceClientSelectCriteria;
            $this->occurrenceRepository = $occurrenceRepository;
            $this->occurrenceClientPhoneRepository = $occurrenceClientPhoneRepository;
            $this->routingService = $routingService;
        }

        public function listClients()
        {
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceClientSelectCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->paginate();

            return view('occurrence_clients.index', compact('occurrence_clients'));
        }

        public function showClient($occurrence_client)
        {
            return view('occurrence_clients.show', compact('occurrence_client'));
        }

        public function editClient($occurrence_client)
        {
            return view('occurrence_clients.edit', compact('occurrence_client'));
        }

        public function updateClient($occurrenceClientRequest, $occurrenceClient)
        {
            $data = $occurrenceClientRequest->all();

            if (!empty($occurrenceClient->lat) && !empty($occurrenceClient->lng)) {

                //COORDENADAS
                $addressClient = trim($occurrenceClient->address) . ", $occurrenceClient->number " . trim($occurrenceClient->district) . " " . trim($occurrenceClient->city) . " " . $occurrenceClient->uf;
                $address = trim($data['address']) . "," . $data['number'] . trim($data['district']) . " " . trim($data['city']) . " " . $data['uf'];

                if ($addressClient != $address) {
                    $coordinates = getCoordsAddressGMAPS($address);

                    $data['lat'] = $coordinates['lat'];
                    $data['lng'] = $coordinates['lng'];
                    $this->routingService->salveRouting(null, [['address' => $data['address']]], [$coordinates], 2);
                }
            }


            $this->occurrenceClientRepository->update($data, $occurrenceClient->id);

            //Deleta os telefones atuais
            $telefones = $this->occurrenceClientPhoneRepository->findWhere(['occurrence_client_id' => $occurrenceClient->id]);
            if (!empty($telefones)) {
                foreach ($telefones as $telefone) {
                    $this->occurrenceClientPhoneRepository->delete($telefone->id);
                }
            }
            $phoneArray = $data["phones"];
            if (!empty($phoneArray)) {
                foreach ($phoneArray as $key => $value) {
                    if ($value != null) {
                        $data2["occurrence_client_id"] = $occurrenceClient->id;
                        $data2["phone"] = $value;
                        $data2["obs"] = $data["obs"][$key];
                        $this->occurrenceClientPhoneRepository->create($data2);
                    }
                }
            }

            return redirect()->route('occurrence_clients.index')->with('message', 'Item atualizado com sucesso.');
        }

        public function storeClient($occurrenceClientRequest)
        {
            $contractor_id = \Auth::user()->contractor_id;
            if (!$contractor_id) {
                return redirect()->route('occurrence_clients.index')->with('error', 'Empreiteira não encontrada');
            }

            $data = $occurrenceClientRequest->all();

            //coordenadas
            // $address = trim($data['address']) .",". $data['number'] . trim($data['district']) ." ". trim($data['city']) ." ". $data['uf'];
            // $coordinates = getCoordsAddressGMAPS($address);

            // $data['lat'] = $coordinates['lat'];
            // $data['lng'] = $coordinates['lng'];
            // $this->routingService->salveRouting(null, [['address' => $data['address']]], [$coordinates], 2);

            if (!isset($data["type_client"]) || empty($data["type_client"])) {
                $data["type_client"] = 3; //Faturado
            }

            $occurrenceClient = $this->occurrenceClientRepository->create($data);

            $phoneArray = $data["phones"];
            foreach ($phoneArray as $key => $value) {
                if (!empty($value)) {
                    $data2["occurrence_client_id"] = $occurrenceClient->id;
                    $data2["phone"] = $value;
                    $data2["obs"] = $data["obs"][$key];
                    $this->occurrenceClientPhoneRepository->create($data2);
                }
            }

            return redirect()->route('occurrence_clients.index')->with('message', 'Item criado com sucesso.');
        }

        public function deleteClient($occurrenceClient)
        {
            $occurrences = $this->occurrenceRepository->findWhere(["occurrence_client_id" => $occurrenceClient->id]);
            if (count($occurrences))
                return redirect()->route('occurrence_clients.index')->with('error', 'Cliente ' . $occurrenceClient->name . ' não pode ser deletado, pois possui OS associada a ele.');

            $this->occurrenceClientRepository->delete($occurrenceClient->id);

            return redirect()->route('occurrence_clients.index')->with('message', 'Cliente excluído com sucesso.');
        }

        public function getClientAjax($id)
        {

            return new ClientFullResource(OccurrenceClient::find($id));
        }

        public function getClientAjaxSelect2($request)
        {

            // $data = $request->input("search");
            //$clientes = $this->occurrenceClientRepository->findWhere(["name"=>$data])->all();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceClientSelectCriteria());
            //        $clientes = $this->occurrenceClientRepository->all();
            $clientes = ClientFullResource::collection($this->occurrenceClientRepository->all());
            return array("items" => $clientes);
        }

        public function listOccurrenceClientByGroup($groupId)
        {
            return $this->occurrenceClientRepository->findWhere(['group_id'=>$groupId]); 
        }

    }
