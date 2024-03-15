<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 15/02/2019
     * Time: 10:55
     */

    namespace App\Services\Api;

    use App\Criteria\Api\OccurrenceOrderCriteria;
    use App\Criteria\Api\OccurrencePendingOrderCriteria;
    use App\Criteria\Api\OccurrenceOrderFlagCriteria;
    use App\Http\Resources\Api\OccurrenceResource;
    use App\Repositories\FinishWorkDayRepository;
    use App\Http\Resources\Api\OccurrenceOrderResource;
    use App\Repositories\OccurrenceClientPhoneRepository;
    use App\Repositories\OccurrenceClientRepository;
    use App\Repositories\OccurrenceDataBasicRepository;
    use App\Repositories\OccurrenceOrderRepository;
    use App\Repositories\OccurrenceRepository;
    use App\Repositories\OccurrenceTypeRepository;
    use App\Repositories\ReallocationRepository;
    use App\Services\OccurrenceOrderService;
    use Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;

    class OccurrenceService
    {
        /**
         * @var OccurrenceRepository
         */
        private $occurrenceRepository;
        /**
         * @var ReallocationRepository
         */
        private $reallocationRepository;
        /**
         * @var OccurrenceImageService
         */
        private $occurrenceImageService;

        /**
         * @var OccurrenceClientRepository
         */
        private $occurrenceClientRepository;
        /**
         * @var OccurrenceClientPhoneRepository
         */
        private $clientPhoneRepository;
        /**
         * @var OccurrenceTypeRepository
         */
        private $occurrenceTypeRepository;
        /**
         * @var OccurrenceDataBasicRepository
         */
        private $occurrenceDataBasicRepository;
        /**
         * @var OccurrenceClientPhoneRepository
         */
        private $occurrenceClientPhoneRepository;
        /**
         * @var FinishWorkDayRepository
         */
        private $finishWorkDayRepository;
        /**
         * @var OccurrenceOrderRepository
         */
        private $occurrenceOrderRepository;
        /**
         * @var OccurrenceOrderService
         */
        private $occurrenceOrderService;

        /**
         * OccurrenceService constructor.
         * @param OccurrenceRepository $occurrenceRepository
         * @param ReallocationRepository $reallocationRepository
         * @param OccurrenceClientPhoneRepository $occurrenceClientPhoneRepository
         * @param OccurrenceDataBasicRepository $occurrenceDataBasicRepository
         * @param OccurrenceTypeRepository $occurrenceTypeRepository
         * @param OccurrenceClientRepository $occurrenceClientRepository
         * @param OccurrenceClientPhoneRepository $clientPhoneRepository
         * @param OccurrenceImageService $occurrenceImageService
         * @param OccurrenceOrderRepository $occurrenceOrderRepository
         * @param OccurrenceOrderService $occurrenceOrderService
         */
        public function __construct(OccurrenceRepository $occurrenceRepository, ReallocationRepository $reallocationRepository, OccurrenceClientPhoneRepository $occurrenceClientPhoneRepository, OccurrenceDataBasicRepository $occurrenceDataBasicRepository, OccurrenceTypeRepository $occurrenceTypeRepository, OccurrenceClientRepository $occurrenceClientRepository, OccurrenceClientPhoneRepository $clientPhoneRepository, OccurrenceImageService $occurrenceImageService, FinishWorkDayRepository $finishWorkDayRepository, OccurrenceOrderRepository $occurrenceOrderRepository, OccurrenceOrderService $occurrenceOrderService)
        {
            $this->occurrenceRepository = $occurrenceRepository;
            $this->reallocationRepository = $reallocationRepository;
            $this->occurrenceImageService = $occurrenceImageService;
            $this->occurrenceClientRepository = $occurrenceClientRepository;
            $this->clientPhoneRepository = $clientPhoneRepository;
            $this->occurrenceTypeRepository = $occurrenceTypeRepository;
            $this->occurrenceDataBasicRepository = $occurrenceDataBasicRepository;
            $this->occurrenceClientPhoneRepository = $occurrenceClientPhoneRepository;
            $this->finishWorkDayRepository = $finishWorkDayRepository;
            $this->occurrenceOrderRepository = $occurrenceOrderRepository;
            $this->occurrenceOrderService = $occurrenceOrderService;
        }

        public function getOsOpenedByOperator($force = false)
        {

            if (!Auth::guard('api')->check()) {
                return response()->json(["error" => "Erro na autenticacao"], 500);
            }

            $operator_id = Auth::guard('api')->user()->id;

            //Os realocada
            $reallocates = $this->reallocationRepository->findWhere([
                "operator_id" => $operator_id,
                "status" => 0
            ], [
                "occurrence_id",
                "id"
            ]);

            foreach ($reallocates as $reallocate) {
                $this->reallocationRepository->update(["status" => 1], $reallocate->id);
            }

            //Os normal
            $this->occurrenceRepository->pushCriteria(new OccurrenceOrderCriteria($operator_id, $force));
            $occurrences = $this->occurrenceRepository->all();

            $this->occurrenceRepository->popCriteria(new OccurrenceOrderCriteria($operator_id, $force));
            $this->occurrenceRepository->pushCriteria(new OccurrenceOrderFlagCriteria());
            $occurrence_orders = $this->occurrenceRepository->all();

            if (count($occurrence_orders) > 0) {

                foreach ($occurrence_orders as $occurrence_order) {
                    $this->occurrenceRepository->update(['order_flag' => $occurrence_order->flag], $occurrence_order->id);
                }

            }

            if (count($occurrences) > 0 || count($reallocates) > 0 || count($occurrence_orders) > 0) {
                return response()->json([
                    "occurrences" => OccurrenceResource::collection($occurrences),
                    "reallocates" => $reallocates,
                    'orders' => OccurrenceOrderResource::collection($occurrence_orders),
                ]);
            } else {
                return response()->json([
                    "occurrences" => [],
                    "reallocates" => [],
                    "orders" => [],
                    "mensagem" => "Não existe novas OSs"
                ]);
            }
        }

        public function getPrevisionByOperator($force = false)
        {

            if (!Auth::guard('api')->check()) {
                return response()->json(["error" => "Erro na autenticacao"], 500);
            }

            $operator_id = Auth::guard('api')->user()->id;


            //Os normal
            $this->occurrenceRepository->pushCriteria(new OccurrencePendingOrderCriteria($operator_id));
            $occurrences = $this->occurrenceRepository->all();

            if (count($occurrences) > 0) {
                return response()->json([
                    "occurrences" => OccurrenceResource::collection($occurrences),
                    "reallocates" => []
                ]);
            } else {
                return response()->json([
                    "occurrences" => [],
                    "reallocates" => [],
                    "mensagem" => "Não existe novas OSs"
                ]);
            }
        }

        public function updateOccurrence(Request $request)
        {

            $data = $request->all();

            $user = Auth::user();

            if (!$request->input("occurrence_id")) {
                return response()->json(['message' => "Id não encontrada"], 500);
            }

            $occurrenceId = $request->input("occurrence_id");
            $statusId = $request->input("status");

            if ($user) {
                $nameFileUser = "user_" . $user->id;
            } else {
                $nameFileUser = "user_nenhum_";
            }

            if (isset($data["occurrence_id"])) {
                $nameFileUser .= "_os_" . $data["occurrence_id"];
            } else {
                $nameFileUser .= "_os_nenhuma";
            }

            $pathLog = "logs/";
            $nameFile = "log_json_" . date("Ymd") . ".log";
            $nameFileUser .= "_log_json_" . date("Ymd") . ".log";

            file_put_contents(storage_path() . "/" . $pathLog . $nameFile, json_encode($data), FILE_APPEND);
            file_put_contents(storage_path() . "/" . $pathLog . $nameFileUser, json_encode($data), FILE_APPEND);

            //Verifica se a OS já foi atendida

            $occurrence = $this->occurrenceRepository->findWhere(["id" => $occurrenceId])->first();

            if (!$occurrence) {
                return response()->json(['message' => "Os não encontrada"], 500);
            } else {
                if ($occurrence->status != 1) {
                    return response()->json(['message' => "Os já foi atualizada"], 500);
                }
            }

            //Salva os dados básicos no banco
            $data2 = array_map(function ($value) {
                return $value === "" ? NULL : $value;
            }, $data);

            $data2["check_in"] = Carbon::parse((isset($data2["check_in"])) ? $data2["check_in"] : null);
            $data2["check_out"] = Carbon::parse((isset($data2["check_out"])) ? $data2["check_out"] : null);
            $data2["check_in_lat"] = (isset($data2["check_in_lat"])) ? $data2["check_in_lat"] : null;
            $data2["check_in_long"] = (isset($data2["check_in_long"])) ? $data2["check_in_long"] : null;
            $data2["check_out_lat"] = (isset($data2["check_out_lat"])) ? $data2["check_out_lat"] : null;
            $data2["check_out_long"] = (isset($data2["check_out_long"])) ? $data2["check_out_long"] : null;

            $data2["date_finish"] = Carbon::now();

            if ($statusId == 3) {
                $data2["cancelamento_status_id"] = (isset($data2["cancelamento_status_id"])) ? $data2["cancelamento_status_id"] : null;
                $data2["motivo_nao_realizacao"] = (isset($data2["obs_os"])) ? $data2["obs_os"] : null;
                unset($data2["obs_os"]);
            }

            try {
                $this->occurrenceRepository->update($data2, $occurrenceId);

                return response()->json(['message' => "Os atualizado com sucesso"]);

            } catch (\Exception $exception) {

                return response()->json(['message' => "Erro ao atualizar OS"], 500);
            }

        }

        public function addNewImagemOccurrence($request)
        {
            return $this->occurrenceImageService->uniqueNewUploadImagemS3($request);
        }

        public function updateOccurrencesStatus($request)
        {
            $data = $request->all();

            $arrayError = array();

            $i = 0;
            foreach ($data as $values) {
                //Atualiza os status
                $data2 = array(
                    "download_at" => Carbon::now()
                );

                try {
                    $this->occurrenceRepository->update($data2, $values);
                    $i++;
                } catch (\Exception $e) {
                    $arrayError[] = $values;
                }
            }
            if (count($arrayError) > 0) {
                return response()->json(array("errors" => [$arrayError]));
            } else {
                return response()->json(array(
                    "errors" => [],
                    "success" => $i
                ));
            }
        }

        public function storeManualOccurrence(Request $request)
        {

            try {
                $data = $request->all();

                $occurrence_type_id = $request->input("occurrence_type_id");
                $client_number = $request->input("client_number");
                $numero_os = $request->input("numero_os");

                $name = $request->input("name");
                $address = $request->input("address");
                $district = $request->input("district");
                $city = $request->input("city");

                $schedule_date = $request->input("schedule_date");
                $schedule_time = $request->input("schedule_time");
                $shift = $request->input("shift");
                $priority = $request->input("priority");

                $operator = Auth::user();
                $operator_id = $operator->getAuthIdentifier();
                $contractor_id = $operator->contractor_id;

                /**
                 * Dados da Occurrence
                 */

                $occurrenceType = $this->occurrenceTypeRepository->findWhere(["id" => $occurrence_type_id])->first();

                if (!$occurrenceType) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Tipo de OS inválida.'
                    ], 500);
                }

                /***
                 * Dados do Client
                 */

                if ($client_number) {
                    $client = $this->occurrenceClientRepository->findWhere(["client_number" => intval(trim($data["client_number"]))])->first();


                    /**
                     * Atualiza se existir se nao cria um novo
                     */

                    if ($client) {
                        $arrayClient = [
                            "name" => ($name) ? trim($name) : $client->name,
                            "address" => ($address) ? trim($address) : $client->address,
                            "district" => ($district) ? trim($district) : $client->district,
                            "city" => ($city) ? trim($city) : $client->city,
                        ];

                        $this->occurrenceClientRepository->update($arrayClient, $client->id);

                    }
                } else {

                    $arrayClient = [
                        "name" => (isset($data["name"])) ? trim($data["name"]) : "",
                        "address" => (isset($data["address"])) ? trim($data["address"]) : "",
                        "district" => (isset($data["district"])) ? trim($data["district"]) : "",
                        "city" => (isset($data["city"])) ? trim($data["city"]) : "",
                        "contractor_id" => $contractor_id
                    ];

                    $client = $this->occurrenceClientRepository->create($arrayClient);
                }

                /**
                 * Telefone dos clientes
                 */
                $telefones = $this->occurrenceClientPhoneRepository->findWhere(["occurrence_client_id" => $client->id], ['phone']);

                $acumulaTelefones = [];

                if (count($telefones)) {
                    foreach ($telefones as $telefone) {
                        $acumulaTelefones[] = $telefone->phone;
                    }
                }

                $phone1 = (isset($data["phone1"])) ? trim($data["phone1"]) : "";
                $phone2 = (isset($data["phone2"])) ? trim($data["phone2"]) : "";
                $phone3 = (isset($data["phone3"])) ? trim($data["phone3"]) : "";

                if (!empty($phone1) && !in_array($phone1, $acumulaTelefones)) {
                    $this->clientPhoneRepository->create([
                        "occurrence_client_id" => $client->id,
                        "phone" => trim($phone1),
                        "obs" => "Os Manual",
                    ]);
                }
                if (!empty($phone2) && !in_array($phone2, $acumulaTelefones)) {
                    $this->clientPhoneRepository->create([
                        "occurrence_client_id" => $client->id,
                        "phone" => trim($phone2),
                        "obs" => "Os Manual",
                    ]);
                }
                if (!empty($phone3) && !in_array($phone3, $acumulaTelefones)) {
                    $this->clientPhoneRepository->create([
                        "occurrence_client_id" => $client->id,
                        "phone" => trim($phone3),
                        "obs" => "Os Manual",
                    ]);
                }


                if (isset($data['schedule_date']) && !empty($data['schedule_date'])) {
                    $scheduleDate = \Carbon\Carbon::createFromFormat('d/m/Y', $schedule_date)->format("Y-m-d");
                } else {
                    $scheduleDate = \Carbon\Carbon::today();
                }


                $dataOccurrence = [
                    "occurrence_type_id" => $occurrenceType->id,
                    "contractor_id" => $contractor_id,
                    "operator_id" => $operator_id,
                    "occurrence_client_id" => $client->id,
                    "numero_cliente" => $client->client_number,
                    "schedule_date" => $scheduleDate,
                    "schedule_time" => ($schedule_time) ? $schedule_time : null,
                    "shift" => ($shift) ? $shift : null,
                    "code_verification" => rand(1000, 9999),
                    "priority" => ($priority) ? $priority : 2,
                    "status" => 1,
                    "numero_os" => $numero_os,
                    "is_manual" => 2,
                    "download_at" => null,
                ];

                $occurrence = $this->occurrenceRepository->create($dataOccurrence);

                $dataForms = $request->input('forms', []);
                $dataForms = array_merge($dataForms, $occurrence->occurrence_type->forms->pluck("id")->toArray());
                //Associa os forms a OS
                $occurrence->forms()->sync($dataForms);

                $dataOccurrenceDataBasic = [
                    "occurrence_id" => $occurrence->id,
                    "operator_id" => $operator_id,
                ];

                $this->occurrenceDataBasicRepository->create($dataOccurrenceDataBasic);

                return response()->json([
                    'success' => true,
                    'message' => 'Os incluída com sucesso',
                    'occurrence_id' => $occurrence->id
                ]);

            } catch (\Exception $exception) {
                return response()->json([
                    'error' => true,
                    'message' => 'Erro:' . $exception->getMessage() . " " . $exception->getLine()
                ]);

            }

        }

        public function storeFinishWorkDay(Request $request)
        {

            try {
                $data = $request->all();

                $operator = Auth::user();
                $operator_id = $operator->getAuthIdentifier();

                $contractor_id = $operator->contractor_id;

                $finishWork = $this->finishWorkDayRepository->create([
                    "operator_id" => $operator_id,
                    "ocurrences_report" => $data['ocurrences_report'],
                    "date_record" => Carbon::parse($data['createdAt']),
                    "status" => $data['status'],
                    "contractor_id" => $contractor_id
                ]);
                $finishWork->save();

                return response()->json([
                    'status' => 1,
                    'message' => 'Dia trabalhado finalizado com sucesso'
                ], 200);

            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 2,
                    'message' => 'Erro ao salvar dia trabalhado'
                ], 500);
            }
        }

        public function order($request)
        {
            $aOrder = $request->all();
            $operator_id = Auth::guard('api')->user()->id;
            // flag para informar se a ordenação vem do celular
            $order_app = 1;
            $this->occurrenceOrderService->addOrderFlag($operator_id, $order_app);
            try {
                if (isset($aOrder["ordem"]) && !empty($aOrder["ordem"])) {
                    foreach ($aOrder["ordem"] as $order) {
                        $arrayBase = [
                            "occurrence_id" => $order["occurrence_id"],
                            "order_client" => $order["order"]
                        ];
                        $this->occurrenceRepository->update($arrayBase, $order["occurrence_id"]);
                    }
                }

                return response()->json([
                    'status' => 1,
                    'message' => 'Ordem OS salva com sucesso'
                ], 200);

            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 2,
                    'message' => 'Erro ao salvar ordem OS'
                ], 500);
            }
        }

    }
