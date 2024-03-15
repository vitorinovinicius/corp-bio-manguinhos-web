<?php
    /**
     * Created by PhpStorm.
     * User: Guilherme
     * Date: 08/11/2016
     * Time: 16:39
     */

    namespace App\Services;


    use App\Criteria\MoveCriteria;
    use App\Criteria\OperatorAjaxCriteria;
    use App\Criteria\OperatorMoveCriteria;
    use App\Exports\RhExportExcel;
    use App\Models\Traking;
    use App\Repositories\AlertRepository;
    use App\Repositories\ContractorRepository;
    use App\Repositories\MoveRepository;
    use App\Repositories\MoveTypeRepository;
    use App\Repositories\OccurrenceRepository;
    use App\Repositories\TrakingRepository;
    use App\Repositories\UserRepository;
    use Artesaos\Defender\Facades\Defender;
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Validator;
    use App\Criteria\OperatorSelectCriteria;
    use App\Criteria\TeamSelectCriteria;
    use App\Repositories\TeamRepository;
    use Illuminate\Http\Request;
    use App\Repositories\VehicleRepository;
    use Maatwebsite\Excel\Facades\Excel;
    use App\Services\RoutingService;
    use App\Repositories\WorkdayRepository;
    use App\Repositories\WorkdayProgramsRepository;
    use App\Repositories\OccurrenceTypeRepository;

    class OperatorService
    {


        /**
         * @var UserRepository
         */
        private $userRepository;
        /**
         * @var TeamRepository
         */
        private $teamRepository;
        /**
         * @var TrakingRepository
         */
        private $trakingRepository;
        /**
         * @var MoveRepository
         */
        private $moveRepository;
        /**
         * @var OccurrenceRepository
         */
        private $occurrenceRepository;
        /**
         * @var SmsService
         */
        private $smsService;
        /**
         * @var ContractorRepository
         */
        private $contractorRepository;

        private $vehicleRespository;
        /**
         * @var RegionService
         */
        private $regionService;
        /**
         * @var AlertRepository
         */
        private $alertRepository;
        /**
         * @var MoveTypeRepository
         */
        private $moveTypeRepository;

        /**
         * @var RoutingService
         */
        private $routingService;

        private $workdayRepository;

        private $workdayProgramsRepository;

        private $occurrenceTypeRepository;

        /**
         * OperatorService constructor.
         * @param UserRepository $userRepository
         * @param TeamRepository $teamRepository
         * @param TrakingRepository $trakingRepository
         * @param MoveRepository $moveRepository
         * @param OccurrenceRepository $occurrenceRepository
         * @param SmsService $smsService
         * @param ContractorRepository $contractorRepository
         * @param VehicleRepository $vehicleRepository
         * @param RegionService $regionService
         * @param AlertRepository $alertRepository
         * @param RoutingService $routingService
         * @param WorkdayProgramsRepository $workdayProgramsRepository
         * @param OccurrenceTypeRepository $occurrenceTypeRepository
         */
        public function __construct(UserRepository $userRepository, TeamRepository $teamRepository, TrakingRepository $trakingRepository, MoveRepository $moveRepository, OccurrenceRepository $occurrenceRepository, SmsService $smsService, ContractorRepository $contractorRepository, VehicleRepository $vehicleRepository, RegionService $regionService, AlertRepository $alertRepository, MoveTypeRepository $moveTypeRepository, RoutingService $routingService, WorkdayRepository $workdayRepository, WorkdayProgramsRepository $workdayProgramsRepository, OccurrenceTypeRepository $occurrenceTypeRepository)
        {

            $this->userRepository = $userRepository;
            $this->teamRepository = $teamRepository;
            $this->trakingRepository = $trakingRepository;
            $this->moveRepository = $moveRepository;
            $this->occurrenceRepository = $occurrenceRepository;
            $this->smsService = $smsService;
            $this->contractorRepository = $contractorRepository;
            $this->vehicleRespository = $vehicleRepository;
            $this->regionService = $regionService;
            $this->alertRepository = $alertRepository;
            $this->moveTypeRepository = $moveTypeRepository;
            $this->routingService = $routingService;
            $this->workdayRepository = $workdayRepository;
            $this->workdayProgramsRepository = $workdayProgramsRepository;
            $this->occurrenceTypeRepository = $occurrenceTypeRepository;
        }

        public function create()
        {
            if (!Auth::user()->contractor_id) {
                return redirect()->route('operators.index')->with('error', 'Apenas Empreiteiras pode criar operador');
            }

            $teams = $this->teamRepository->all();

            $vehicles = $this->vehicleRespository->findWhere(['allocated' => 0]);

            $regions = $this->regionService->listRegions();

            $workdays = $this->workdayRepository->all();

            return view('operators.create', compact("teams", 'regions', 'vehicles', 'workdays'));
        }

        public function addNewOperator($request)
        {
            if (!Auth::user()->contractor_id) {
                return redirect()->back()->withInput()->with('error', 'O técnico só pode ser cadastrado pela empreiteira.');
            }

            $data = $request->all();

            //FAZ A BUSCA DAS COORDENADAS

            //ponto de partida
            if (isset($data["operator_start_point"]) && !empty($data["operator_start_point"])) {
                $startPoint = getCoordsAddressGMAPS($data["operator_start_point"]);
                $this->routingService->salveRouting(null, [['address' => $data['operator_start_point']]], [$startPoint], 2);
                $data['operator_start_lat'] = $startPoint['lat'];
                $data['operator_start_lng'] = $startPoint['lng'];
            }

            //ponto de chegada
            if (isset($data["operator_arrival_point"]) && !empty($data["operator_arrival_point"])) {
                if ($data["operator_start_point"] != $data["operator_arrival_point"]) {
                    $arrivalPoint = getCoordsAddressGMAPS($data["operator_arrival_point"]);
                    $this->routingService->salveRouting(null, [['address' => $data['operator_arrival_point']]], [$arrivalPoint], 2);
                    $data['operator_arrival_lat'] = $arrivalPoint['lat'];
                    $data['operator_arrival_lng'] = $arrivalPoint['lng'];
                } else {
                    $data['operator_arrival_lat'] = $startPoint['lat'];
                    $data['operator_arrival_lng'] = $startPoint['lng'];
                }
            }

            $contractor = $this->contractorRepository->all();

            $data["email"] = strtolower($data["email"]);
            $data["password"] = bcrypt(strtolower($data["password"]));

            if (empty($data["mobile_number"])) {
                $data["mobile_number"] = 0;
            }

            if (isset($data["valid"]) && !empty($data["valid"])) {
                $data["valid"] = Carbon::createFromFormat('d/m/Y', $data["valid"])->toDateString();
            } else {
                $data["valid"] = null;
            }

            if (isset($data['manometro']) && !empty($data['manometro'])) {
                $data['manometro'] = $this->equipmentNumber($data['manometro'], $contractor);
            }

            if (isset($data['detector_de_gas']) && !empty($data['detector_de_gas'])) {
                $data['detector_de_gas'] = $this->equipmentNumber($data['detector_de_gas'], $contractor);
            }

            if (isset($data["manometro_validade"]) && !empty($data["manometro_validade"])) {
                $data["manometro_validade"] = Carbon::createFromFormat('d/m/Y', $data["manometro_validade"])->toDateString();
            }

            if (isset($data["analisador_validade"]) && !empty($data["analisador_validade"])) {
                $data["analisador_validade"] = Carbon::createFromFormat('d/m/Y', $data["analisador_validade"])->toDateString();
            }

            if (isset($data["cnh_expires"]) && !empty($data["cnh_expires"])) {
                $data["cnh_expires"] = Carbon::createFromFormat('d/m/Y', $data["cnh_expires"])->toDateString();
            }


            //verifica se o usuário já pertence a alguma equipe
            $operator = $this->userRepository->create($data);

            if (isset($data['region_id'])) {
                $operator->regions()->attach($data['region_id']);
            }


            $role = Defender::findRoleById(4);
            $operator->attachRole($role);

            //Associa à equipe
            if (!empty($data["team_id"])) {
                $dataFinal[$data['team_id']] = ['is_supervisor' => false];
                $operator->teams()->attach($dataFinal);
            }

            $certificate = $request->file('certificate');
            if ($certificate) {
                $operator->certificate = $this->uploadS3($certificate, "certificado", $operator);
            }

            $foto = $request->file('foto');
            if ($foto) {
                $operator->foto = $this->uploadS3($foto, "foto", $operator);
            }

            $assinatura = $request->file('assinatura');
            if ($assinatura) {
                $operator->assinatura = $this->uploadS3($assinatura, "assinatura", $operator);
            }

            /*UPLOAD DOS CERTIFICADOS DE EQUIPAMENTO*/

            $manometro_certificado = $request->file('manometro_certificado');
            if ($manometro_certificado) {
                $operator->manometro_certificado = $this->uploadS3($manometro_certificado, "manometro_certificado", $operator);
            }

            $analisador_certificado = $request->file('analisador_certificado');
            if ($analisador_certificado) {
                $operator->analisador_certificado = $this->uploadS3($analisador_certificado, "analisador_certificado", $operator);
            }

            $operator->save();


        }

        public function listOperators()
        {
            if (\Request::get('export')) {
                return $this->export();
            }

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->paginate();

            $this->teamRepository->pushCriteria(new TeamSelectCriteria());
            $teams = $this->teamRepository->all();

            $contractors = $this->contractorRepository->all();

            return view('operators.index', compact('operators', 'teams', 'contractors'));
        }

        public function edit($operator)
        {
            $teams = $this->teamRepository->all();

            $vehicles = $this->vehicleRespository->findWhere(['allocated' => 0]);

            $workdays = $this->workdayRepository->all();

            $regions = $this->regionService->listRegions();

            $selectedRegions = [];

            foreach ($operator->regions as $region) {
                $selectedRegions[] = $region->id;
            }


            return view('operators.edit', compact('operator', 'teams', 'regions', 'selectedRegions', 'vehicles', 'workdays'));
        }

        public function updateOparator($request, $user)
        {
            $data = $request->all();

            $contractor = $this->contractorRepository->all();


            $data["email"] = strtolower($data["email"]);

            if (isset($data['manometro']) && !empty($data['manometro'])) {
                $data['manometro'] = $this->equipmentNumber($data['manometro'], $contractor);
            } else {
                $data['manometro'] = "NÃO POSSUI";
            }

            if (isset($data['detector_de_gas']) && !empty($data['detector_de_gas'])) {
                $data['detector_de_gas'] = $this->equipmentNumber($data['detector_de_gas'], $contractor);
            } else {
                $data['detector_de_gas'] = "NÃO POSSUI";
            }

            $certificate = $request->file('certificate');
            if ($certificate) {
                $data["certificate"] = $this->uploadS3($certificate, "certificates", $user);
            }

            $foto = $request->file('foto');
            if ($foto) {
                $data["foto"] = $this->uploadS3($foto, "fotos", $user);
            }

            $assinatura = $request->file('assinatura');
            if ($assinatura) {
                $data["assinatura"] = $this->uploadS3($assinatura, "assinaturas", $user);
            }

            /*UPLOAD DOS CERTIFICADOS DE EQUIPAMENTO*/

            $manometro_certificado = $request->file('manometro_certificado');
            if ($manometro_certificado) {
                $data["manometro_certificado"] = $this->uploadS3($manometro_certificado, "manometro_certificado", $user);
            }

            $analisador_certificado = $request->file('analisador_certificado');
            if ($analisador_certificado) {
                $data["analisador_certificado"] = $this->uploadS3($analisador_certificado, "analisador_certificado", $user);
            }

            if (empty($data["mobile_number"])) {
                $data["mobile_number"] = 0;
            }

            if (isset($data["valid"]) && !empty($data["valid"])) {
                $data["valid"] = Carbon::createFromFormat('d/m/Y', $data["valid"])->toDateString();
            } else {
                $data["valid"] = ($user->valid) ? $user->valid : null;
            }

            if (isset($data["manometro_validade"]) && !empty($data["manometro_validade"])) {
                $data["manometro_validade"] = Carbon::createFromFormat('d/m/Y', $data["manometro_validade"])->toDateString();
            } else {
                $data["manometro_validade"] = ($user->manometro_validade) ? $user->manometro_validade : null;
            }

            if (isset($data["manometro_calibracao"]) && !empty($data["manometro_calibracao"])) {
                $data["manometro_calibracao"] = Carbon::createFromFormat('d/m/Y', $data["manometro_calibracao"])->toDateString();
            } else {
                $data["manometro_calibracao"] = ($user->manometro_calibracao) ? $user->manometro_calibracao : null;
            }

            if (isset($data["analisador_validade"]) && !empty($data["analisador_validade"])) {
                $data["analisador_validade"] = Carbon::createFromFormat('d/m/Y', $data["analisador_validade"])->toDateString();
            } else {
                $data["analisador_validade"] = ($user->analisador_validade) ? $user->analisador_validade : null;
            }

            if (isset($data["analisador_calibracao"]) && !empty($data["analisador_calibracao"])) {
                $data["analisador_calibracao"] = Carbon::createFromFormat('d/m/Y', $data["analisador_calibracao"])->toDateString();
            } else {
                $data["analisador_calibracao"] = ($user->analisador_calibracao) ? $user->analisador_calibracao : null;
            }

            //        $data["password"] = strtolower($data["password"]);
            //
            //        if (isset($data["password"]) && !empty($data["password"])) {
            //            $data["password"] = bcrypt($data["password"]);
            //        } else {
            //            unset($data["password"]);
            //        }

            if ($user->teams->count() == 0) {
                //coloca um novo time
                $dataFinal[$data['team_id']] = ['is_supervisor' => false];
                $user->teams()->attach($dataFinal);
            }

            if ($user->vehicle_id) {
                $this->vehicleRespository->update(['allocated' => 0], $user->vehicle_id);
            }

            if (isset($data["vehicle_id"]) && !empty($data["vehicle_id"])) {
                $this->vehicleRespository->update(['allocated' => 1], $data["vehicle_id"]);
            }

            //VERIFICA ENDEREÇO E COORDENADAS
            if (isset($data['operator_start_point']) && !empty($data['operator_start_point'])) {
                if ($user->operator_start_point != $data['operator_start_point']) {

                    $startPoint = getCoordsAddressGMAPS($data["operator_start_point"]);
                    $this->routingService->salveRouting(null, [['address' => $data['operator_start_point']]], [$startPoint], 2);
                    $data['operator_start_lat'] = $startPoint['lat'];
                    $data['operator_start_lng'] = $startPoint['lng'];
                }
            } else {
                $data['operator_start_lat'] = "";
                $data['operator_start_lng'] = "";
            }

            if (isset($data['operator_arrival_point']) && !empty($data['operator_arrival_point'])) {
                if ($user->operator_arrival_point != $data['operator_arrival_point']) {
                    $arrivalPoint = getCoordsAddressGMAPS($data["operator_arrival_point"]);
                    $this->routingService->salveRouting(null, [['address' => $data['operator_arrival_point']]], [$arrivalPoint], 2);
                    $data['operator_arrival_lat'] = $arrivalPoint['lat'];
                    $data['operator_arrival_lng'] = $arrivalPoint['lng'];
                }
            } else {
                $data['operator_arrival_lat'] = "";
                $data['operator_arrival_lng'] = "";
            }

            if (isset($data["cnh_expires"]) && !empty($data["cnh_expires"])) {
                $data["cnh_expires"] = Carbon::createFromFormat('d/m/Y', $data["cnh_expires"])->toDateString();
            }

            $this->userRepository->update($data, $user->id);

            if ($user->teams->count() == 0) {
                //coloca um novo time
                $dataFinal[$data['team_id']] = ['is_supervisor' => false];
                $user->teams()->attach($dataFinal);
            } else {

                if (!empty($data["team_id"]) && ($user->teams[0]->id != $data["team_id"])) {
                    //remove o time atual
                    $user->teams()->detach([$user->teams[0]->id]);

                    //coloca um novo time
                    $dataFinal[$data['team_id']] = ['is_supervisor' => false];
                    $user->teams()->attach($dataFinal);
                }
            }
            //        if (isset($data['region_id'])) {
            //            $user->regions()->sync($data['region_id']);
            //        }

            if (isset($data['role_id'])) {
                $user->syncRoles($data["role_id"]);
            }


        }

        public function updateLocation($request)
        {
            try {
                if (!Auth::guard('api')->check()) {
                    $arrayError = array("data" => array("error-0" => "Erro na autenticacao"));

                    return $arrayError;
                }

                $user_id = Auth::guard('api')->user()->id;

                $data = $request->all();

                $validations = [
                    'latitude' => 'required|numeric',
                    'longitude' => 'required|numeric'
                ];

                $validator = Validator::make($data, $validations);
                $data['last_connection'] = Carbon::now();
                $data["platform_mobile"] = (isset($data["platform_mobile"])) ? $data["platform_mobile"] : null;
                $data["battery"] = (isset($data["battery"])) ? $data["battery"] : null;
                $data["model"] = (isset($data["model"])) ? $data["model"] : null;

                if ($validator->fails()) {
                    unset($data["latitude"]);
                    unset($data["longitude"]);
                    $this->userRepository->update($data, $user_id);
                    return [
                        'error' => true,
                        'error_details' => $validator->errors()->all()
                    ];
                }

                //Salva o dado de traking
                $data["user_id"] = $user_id;
                $data["tipo_conexao"] = (isset($data["tipo_conexao"])) ? $data["tipo_conexao"] : null;
                $data["isConnect"] = (isset($data["isConnect"])) ? $data["isConnect"] : null;
                $data["order_flag"] = 0;

                $data["ip"] = getUserIP();


                $this->trakingRepository->create($data);

                $this->userRepository->update($data, $user_id);

                return response()->json(["success" => "Track recebido com sucesso"]);

            } catch (\Exception $e) {
                return response()->json(["error" => "Erro ao processar track"], 500);
            }
        }

        public function saveMove(Request $request)
        {
            if (!Auth::guard('api')->check()) {
                $arrayError = array("data" => array("error-0" => "Erro na autenticacao"));

                return $arrayError;
            }
            try {
                $user = Auth::user();

                $data = $request->all();

                $dataIn["operator_id"] = $user->id;
                $dataIn["occurrence_id"] = (isset($data["occurrence_id"])) ? $data["occurrence_id"] : null;
                $dataIn["move_type_id"] = (isset($data["movesTypeId"])) ? $data["movesTypeId"] : null;

                $dataIn["check_in"] = (isset($data["check_in"])) ? $data["check_in"] : null;
                $dataIn["check_in_long"] = (isset($data["check_in_long"])) ? $data["check_in_long"] : null;
                $dataIn["check_in_lat"] = (isset($data["check_in_lat"])) ? $data["check_in_lat"] : null;

                //verifica se existe o move
                $move_check = $this->moveRepository->findWhere([
                    "check_in" => $dataIn["check_in"],
                    "move_type_id" => $dataIn["move_type_id"],
                ])->first();

                if($move_check){
                    return response()->json(['status' => 1]);
                }

                $move = $this->moveRepository->create($dataIn);

                if ($dataIn["move_type_id"] == 4 && $dataIn["occurrence_id"]) {
                    //Saída para atendimento

                    $occurrence = $this->occurrenceRepository->find($data["occurrence_id"]);
                    if ($occurrence) {
                        $this->smsService->enviaSms($occurrence);
                    }
                }
            } catch (\Exception $e) {
                //                Storage::disk('public')->prepend('log/sms', $e->getMessage());
                geraActivityLog("SMS - Erro", "Erro ao salvar/Enviar o SMS", $e->getMessage());
            }


            try {

                //CALCULA ATRASO PARA GERAR ALERTA DE ATRASO NO ATENDIMENTO DA OS
                if ($dataIn["move_type_id"] == 5 && $dataIn["occurrence_id"]) {
                    //Chegada no local do atendimento

                    $occurrence = $this->occurrenceRepository->find($dataIn["occurrence_id"]);
                    if ($occurrence) {
                        //Verifica se tem hora de agendamento
                        if (!empty($occurrence->schedule_time)) {
                            $start_time = Carbon::parse($occurrence->schedule_time);
                            $finish_time = Carbon::now();

                            $totalDuration = $finish_time->diffInSeconds($start_time, false);
                            if ($totalDuration < 0) {
                                //Salva alerta
                                $dataAlert = array(
                                    "occurrence_id" => $dataIn["occurrence_id"],
                                    "contractor_id" => $user->contractor_id,
                                    "detail" => "A OS de ID " . $dataIn["occurrence_id"] . " foi atendida com " . gmdate('H:i:s', $finish_time->diffInSeconds($start_time)) . " de atraso.",
                                    "type" => 1,
                                    "user_id" => $user->id,
                                );

                                $this->alertRepository->create($dataAlert);

                            }
                        }
                    }
                }

                //CALCULA ESTOURO NO TEMPO DE ATENDIMENTO
                if ($dataIn["move_type_id"] == 7) { //Fechar Atendimento
                    //pegar o tipo de os e o seu tempo medio
                    $occurrence = $this->occurrenceRepository->find($dataIn["occurrence_id"]);
                    $occurenceType = $this->occurrenceTypeRepository->find($occurrence->occurrence_type_id);

                    if ($occurenceType->average_time) {

                        $average_time = Carbon::parse($occurenceType->average_time);

                        //pegar a hora de inicio e fim do atendimento e calcular sua diferença
                        $day = Carbon::now();
                        $inicioAtendimento = $this->moveRepository->findWhere([
                            'operator_id' => $user->id,
                            'occurrence_id' => $occurrence->id,
                            'move_type_id' => 6,
                            [
                                'check_in',
                                'LIKE',
                                $day->format('Y-m-d') . '%'
                            ]
                        ])->last();

                        if ($inicioAtendimento) {
                            $fimAtendimento = Carbon::parse($move->check_in);

                            $inicioAtendimento = Carbon::parse($inicioAtendimento['check_in']);

                            //calcula tempo médio
                            $totalMedio = carbon::parse($fimAtendimento->diff($inicioAtendimento)->format("%H:%I:%S"));

                            if ($totalMedio->diffInMinutes($average_time) > 0) {
                                //Salva alerta
                                $dataAlert = array(
                                    "type" => 4,
                                    "user_id" => $user->id,
                                    "occurrence_id" => $dataIn["occurrence_id"],
                                    "contractor_id" => $user->contractor_id,
                                    "detail" => "A técnico " . $user->name . " excedeu o tempo médio de atendimento em  " . $totalMedio->diffForHumans($average_time) . ".",
                                );

                                $this->alertRepository->create($dataAlert);
                            }
                        }
                    }
                }


                //CALCULA HORAS TRABALHADAS PRA GERAR ALERTA DE HORAS EXTRA
                if ($dataIn["move_type_id"] == 8) { //Fim da Jornada de Trabalho

                    if ($user->workday_id) {

                        //dia da semana no momento
                        $day = Carbon::now();
                        $dayWeek = $day->dayOfWeek + 1;//soma 1 porque o carbom começa a contar do 0 e no banco começa no 1

                        //select no user pra saber o total de horas pra ele naquele dia da semana
                        $workday = $this->workdayProgramsRepository->findWhere([
                            'workday_id' => $user->workday_id,
                            'day' => $dayWeek
                        ])->last();

                        if ($workday) {
                            $horaProgramada = $workday->hour;
                            $horaProgramada = Carbon::parse("{$horaProgramada}:00:00");

                            //pegar o total de horas trabalhada no dia
                            $jornadaInicial = $this->getLastMoveToday(1, $day, $user->id);
                            $jornadaInicioAlmoco = $this->getLastMoveToday(2, $day, $user->id);
                            $jornadaFimAlmoco = $this->getLastMoveToday(3, $day, $user->id);

                            if ($jornadaInicial) {

                                $totalTrabalhada = $this->calcJornada($jornadaInicial, $move, $jornadaInicioAlmoco, $jornadaFimAlmoco);

                                if ($totalTrabalhada > $horaProgramada) {
                                    //Salva alerta
                                    $dataAlert = array(
                                        "type" => 5,
                                        "user_id" => $user->id,
                                        "contractor_id" => $user->contractor_id,
                                        "detail" => "A técnico " . $user->name . " excedeu horas trabalhas em " . $totalTrabalhada->diff($horaProgramada)->format("%H:%I:%S"),
                                    );

                                    $this->alertRepository->create($dataAlert);
                                }
                            }
                        }
                    }
                }

            } catch (\Exception $e) {
                geraActivityLog("Move - Erro", "Erro ao salvar o Move", $e->getMessage());
            }

            return response()->json(['status' => 1]);
        }

        public function getAllOperators()
        {
            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            return $this->userRepository->all();
        }

        public function showOperator($operator, $request)
        {

            //Pega as equipes que o usuário participa
            $teams = $operator->teams()->paginate();
            $occurrencesDays = $operator->occurrencesDays;
            $data = Carbon::today();
            $dataTracking = $data->format("Y-m-d");

            //DB::raw('CURDATE()')
            $tracking = $operator->tracking()->where("created_at", ">=", $dataTracking)->orderBy('created_at', 'desc')->limit(23)->get();

            $trackingCollection = $tracking;

            $total = count($tracking);

            $primeiroEndereco = "";
            $ultimoEndereco = "";

            if ($total > 0) {
                $primeiroEndereco = $tracking[$total - 1];
                $ultimoEndereco = $tracking[0];
            }

            $listTrack = [];


            foreach ($tracking as $track) {

                if (($primeiroEndereco->latitude != $track->latitude && $primeiroEndereco->longitude != $track->longitude) or ($ultimoEndereco->latitude != $track->latitude && $ultimoEndereco->longitude != $track->longitude)) {

                    $trackObj = new Traking();
                    $trackObj->latitude = $track->latitude;
                    $trackObj->longitude = $track->longitude;

                    $listTrack[] = $trackObj;

                }
            }

            /*
             * Calcula tempo médio de atendimento
             */

            $listAvgChackInCheckOut = [];
            $occurrencesDaysCloseds = $occurrencesDays->where("status", "!=", 1);
            foreach ($occurrencesDaysCloseds as $occurence) {
                $listAvgChackInCheckOut[] = calcDiffMinute($occurence->check_in, $occurence->check_out);
            }

            $somaTotal = array_sum($listAvgChackInCheckOut);
            $quantidadeOs = $occurrencesDaysCloseds->count();
            if ($quantidadeOs > 0 && $somaTotal > 0) {
                $tempoAtendimentoPorOs = (round($somaTotal / $quantidadeOs));
            } else {
                $tempoAtendimentoPorOs = 0;
            }

            $tracking = $listTrack;

            sort($tracking);

            $scheduled_date = $request->input('scheduled_date');

            $dataIni = '';
            $dataFim = '';

            if ($scheduled_date) {
                $dataTracking = $scheduled_date;

                $explodData = explode("-", $scheduled_date);
                $explodDataIni = explode("/", trim($explodData[0]));
                $explodDataFim = explode("/", trim($explodData[1]));


                $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                if ($dataIni != "" && $dataFim != "") {
                    $schedules_all = $operator->occurrences->whereBetween('schedule_date', [
                        $dataIni,
                        $dataFim
                    ])->count();
                    $schedules_pending = $operator->occurrences->whereBetween('schedule_date', [
                        $dataIni,
                        $dataFim
                    ])->where('status', 1)->count();
                    $schedules_realized = $operator->occurrences->whereBetween('schedule_date', [
                        $dataIni,
                        $dataFim
                    ])->where('status', 2)->count();
                    $schedules_unsolved = $operator->occurrences->whereBetween('schedule_date', [
                        $dataIni,
                        $dataFim
                    ])->where('status', 3)->count();

                } else {
                    $schedules_all = $operator->occurrences->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->count();
                    $schedules_pending = $operator->occurrences->where('schedule_date', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->where('status', 1)->count();
                    $schedules_realized = $operator->occurrences->where('schedule_date', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->where('status', 2)->count();
                    $schedules_unsolved = $operator->occurrences->where('schedule_date', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->where('status', 3)->count();
                }
            } else {
                $schedules_all = $operator->occurrences->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->count();
                $schedules_pending = $operator->occurrences->where('schedule_date', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->where('status', 1)->count();
                $schedules_realized = $operator->occurrences->where('schedule_date', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->where('status', 2)->count();
                $schedules_unsolved = $operator->occurrences->where('schedule_date', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->where('status', 3)->count();
            }


            $attendece_first = $operator->occurrencesDaysCheckin->first();
            $attendece_last = $operator->occurrencesDaysCheckout->first();


            if ($scheduled_date) {
                $this->moveRepository->pushCriteria(new OperatorMoveCriteria($operator->id, $dataTracking, true));
            } else {
                $this->moveRepository->pushCriteria(new OperatorMoveCriteria($operator->id, $dataTracking, false));
            }
            $moves = $this->moveRepository->all();

            return view('operators.show', compact('operator', 'teams', 'occurrencesDays', 'tempoAtendimentoPorOs', 'tracking', 'primeiroEndereco', 'trackingCollection', 'ultimoEndereco', 'schedules_all', 'schedules_realized', 'schedules_pending', 'schedules_unsolved', 'attendece_first', 'attendece_last', 'moves', 'dataIni', 'dataFim'));
        }

        private function uploadS3($arquivo, $string, $user)
        {
            $archivePath = "temp/";
            $fileName = md5(date("Y_m_d_h_i_s")) . "." . $arquivo->getClientOriginalExtension();
            $path = $archivePath . $fileName;
            $arquivo->move($archivePath, $fileName);
            $s3Client = Storage::disk('s3');
            $cert_name = env("S3_PATH") . $user->contractor->id . "/user/" . $user->id . "/" . $string . "/" . $fileName;

            if (\File::exists($path)) {
                $contents = \File::get($path);
                $s3Client->put($cert_name, $contents);
                \File::delete($path);
                return $s3Client->url($cert_name);
            }
        }

        public function updateProfile($request)
        {
            if (!Auth::guard('api')->check()) {
                $arrayError = array("data" => array("error-0" => "Erro na autenticacao"));
                return $arrayError;
            }

            $user_id = Auth::guard('api')->user()->id;

            $data = $request->all();
            $this->userRepository->update($data, $user_id);

            return ['status' => 1];
        }

        private function equipmentNumber($equipment, $contractor)
        {
            $equipment = preg_replace("/[^0-9]/", "", $equipment);
            return substr($contractor->name, 0, 3) . '-' . $equipment;
        }

        private function export()
        {

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();

            $data = array();

            foreach ($operators as $key => $operator) {
                $data[$key]['ID'] = $operator->id;
                $data[$key]['ECC'] = optional($operator->contractor)->name;
                $data[$key]['NOME'] = $operator->name;
                $data[$key]['CPF'] = (!empty($operator->cpf) ? $this->maskCpf($operator->cpf) : "");
                $data[$key]['E-MAIL'] = $operator->email;
                $data[$key]['STATUS'] = ($operator->status == 1) ? "Habilitado" : "Desabilitado";
                $data[$key]['EQUIPAMENTO (CELULAR)'] = $operator->device . "Version:" . $operator->device_version;
                $data[$key]['CÓDIGO DO CELULAR'] = $operator->mobile_number;
                $data[$key]['MANÔMETRO'] = ($operator->manometro) ? $operator->manometro : "NÃO POSSUI";
                $data[$key]['ANALISADOR DE GÁS'] = ($operator->detector_de_gas) ? $operator->detector_de_gas : "NÃO POSSUI";;
                $data[$key]['CNH'] = ($operator->cnh) ? ($operator->cnh) : "NÃO POSSUI";
                $data[$key]['TIPO CNH'] = ($operator->cnh_type) ? $operator->cnh_type : "NÃO POSSUI";
                $data[$key]['VENCIMENTO CNH'] = ($operator->cnh_expires) ? $operator->cnh_expires() : "NÃO POSSUI";
                $data[$key]['VEÍCULO - PLACA'] = (optional($operator->vehicle)->placa) ? $operator->vehicle->placa : "NÃO POSSUI";
                $data[$key]['VEÍCULO - MARCA'] = (optional($operator->vehicle)->brand) ? $operator->vehicle->brand : "NÃO POSSUI";
                $data[$key]['VEÍCULO - MODELO'] = (optional($operator->vehicle)->model) ? $operator->vehicle->model : "NÃO POSSUI";
            }

            Excel::create('CentralMob-Tecnicos', function ($excel) use ($data) {

                $excel->sheet('Geral', function ($sheet) use ($data) {

                    $sheet->fromArray($data);
                });

            })->download('xls');
        }

        private function maskCpf($cpf)
        {
            $mask = '###.###.###-##';
            $cpf = str_replace('-', '', str_replace(".", "", $cpf));
            if (is_numeric($cpf) && strlen($cpf) == 11) {
                for ($i = 0; $i < strlen($cpf); $i++) {
                    $mask[strpos($mask, "#")] = $cpf[$i];
                }
            } else {
                return $cpf;
            }
            return $mask;
        }

        public function listWorkday()
        {

            $this->moveRepository->pushCriteria(new MoveCriteria());
            if (\Request::get('export')) {
                //            $this->exportRh();
                $moves = $this->moveRepository->all();
                if (\Request::get('export') == "exportPdf") {
                    return Excel::download(new RhExportExcel($moves), "Central System - RH.pdf", \Maatwebsite\Excel\Excel::TCPDF);
                } else {
                    return Excel::download(new RhExportExcel($moves), "Central System - RH.xlsx");
                }
            }

            $moves = $this->moveRepository->paginate();
            $move_types = $this->moveTypeRepository->whereIn('id', [
                1,
                2,
                3,
                8
            ])->get();

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();

            $contractors = $this->contractorRepository->all();

            return view('operators.rh.index', compact('moves', 'contractors', 'operators', 'move_types'));
        }

        public function ajax($id)
        {
            $operators = $this->userRepository->pushCriteria(new OperatorAjaxCriteria($id))->all();
            return $operators;
        }

        public function lisTracking($operator, $request)
        {
            $scheduledDate = str_replace("/", "-", $request->input('schedule_date'));
            $scheduledTime = $request->input('schedule_time');

            if (!$scheduledDate) {
                $data = Carbon::now();
                $dataTracking = $data->format("Y-m-d");

                //DB::raw('CURDATE()')
                $trackings = $operator->tracking()
                    //                ->where("created_at", ">=", $dataTracking)
                    ->orderBy('created_at', 'desc')->limit(30)->get();
            } else {
                $dateTimeStart = Carbon::parse($scheduledDate)->format('Y-m-d') . ' ' . $scheduledTime;
                $dateTimeEnd = Carbon::parse($dateTimeStart)->addHour();


                $trackings = Traking::select('*')->whereBetween('created_at', [
                        $dateTimeStart,
                        $dateTimeEnd
                    ])->where('user_id', '=', $operator->id)->get();

            }

            return view('operators.tracking', compact('operator', 'trackings'));
        }

        private function calcJornada($inicioJornada, $fimJornada, $inicioAlmoco, $fimAlmoco)
        {
            $inicioJornada = Carbon::parse($inicioJornada->check_in);
            $fimJornada = Carbon::parse($fimJornada->check_in);
            $totalJornada = Carbon::parse($fimJornada->diff($inicioJornada)->format("%H:%I:%S"));


            if ($inicioAlmoco && $fimAlmoco) {

                $inicioAlmoco = Carbon::parse($inicioAlmoco->check_in);
                $fimAlmoco = Carbon::parse($fimAlmoco->check_in);

                $totalAlmoco = Carbon::parse($fimAlmoco->diff($inicioAlmoco)->format("%H:%I:%S"));

                $totalJornada = Carbon::parse($totalJornada->diff($totalAlmoco)->format("%H:%I:%S"));
            }


            return $totalJornada;
        }

        private function getLastMoveToday($move_type_id, $day, $operator_id)
        {
            return $this->moveRepository->findWhere([
                'operator_id' => $operator_id,
                'move_type_id' => $move_type_id,
                [
                    'check_in',
                    'LIKE',
                    '%' . $day->format('Y-m-d') . '%'
                ]
            ])->last();
        }
    }
