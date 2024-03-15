<?php

use App\Models\Ticket;
    /**
     * Created by PhpStorm.
     * User: CELTAPHP
     * Date: 16/11/2016
     * Time: 12:51
     */

    namespace App\Services;

    use App\Criteria\Api\InterferenceCriteria;
    use App\Criteria\OccurrenceTypeCriteria;
    use App\Criteria\OccurrenceAdjustedCriteria;
    use App\Criteria\OccurrenceApprovedCriteria;
    use App\Criteria\OccurrenceCityCriteria;
    use App\Criteria\OccurrenceDisapprovedCriteria;
    use App\Criteria\OccurrenceNotExecutedCriteria;
    use App\Criteria\OccurrenceToAdjustCriteria;
    use App\Criteria\OccurrenceStatusScheduleCriteria;
    use App\Criteria\OccurrenceToApprovedCriteria;
    use App\Criteria\PlanOccurrenceCreateCriteria;
    use App\Models\CancelamentoStatus;
    use App\Models\User;
    use App\Repositories\ContractorDistrictRepository;
    use App\Repositories\ContractorOccurrenceTypeRepository;
    use App\Repositories\ContractorRepository;
    use App\Repositories\DistrictRepository;
    use App\Repositories\FormGroupRepository;
    use App\Repositories\OccurrenceClientPhoneRepository;
    use App\Repositories\OccurrenceDataBasicRepository;
    use App\Repositories\OccurrenceTypeFormRepository;
    use App\Repositories\OccurrenceTypeSkillRepository;
    use App\Repositories\ReallocationRepository;
    use App\Repositories\UserSkillRepository;
    use Carbon\Carbon;
    use Exception;
    use File;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Validator;
    use Maatwebsite\Excel\Excel;
    use App\Criteria\OccurrenceClosedCriteria;
    use App\Criteria\OccurrenceClosedUnsolvedCriteria;
    use App\Criteria\OccurrencePendingCriteria;
    use App\Criteria\OccurrencePlanOccurrenceCriteria;
    use App\Criteria\OccurrenceSelectCriteria;
    use App\Criteria\OccurrenceUnassignedCriteria;
    use App\Criteria\OperatorSelectCriteria;
    use App\Repositories\OccurrenceClientRepository;
    use App\Repositories\OccurrenceImageRepository;
    use App\Repositories\OccurrenceRepository;
    use App\Repositories\OccurrenceTypeRepository;
    use App\Repositories\UserRepository;
    use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
    use App\Models\OccurrenceDynamo;
use App\Models\Ticket;
use App\Repositories\InterferenceRepository;
    use App\Repositories\OccurrenceDataClientRepository;
    use App\Repositories\PlanOccurrenceRepository;
    use App\Repositories\WorkdayProgramsRepository;
    use App\Repositories\OccurrencePdfRepository;

    class OccurrenceService
    {

        private $occurrenceRepository;
        private $occurrenceClientRepository;
        private $occurrenceTypeRepository;
        private $userRepository;
        private $occurrenceImageRepository;
        private $interferenceRepository;
        private $occurrenceDataClientRepository;
        private $planOccurrenceRepository;

        private $reallocationRepository;
        /**
         * @var FormGroupRepository
         */
        private $formGroupRepository;
        /**
         * @var OccurrenceTypeFormRepository
         */
        private $occurrenceTypeFormRepository;
        /**
         * @var OccurrenceDataBasicRepository
         */
        private $occurrenceDataBasicRepository;
        /**
         * @var ContractorRepository
         */
        private $contractorRepository;
        /**
         * @var OccurrenceClientPhoneRepository
         */
        private $occurrenceClientPhoneRepository;
        /**
         * @var OccurrenceArchiveService
         */
        private $occurrenceArchiveService;
        /**
         * @var DistrictRepository
         */
        private $districtRepository;
        /**
         * @var ContractorOccurrenceTypeRepository
         */
        private $contractorOccurrenceTypeRepository;
        /**
         * @var ContractorDistrictRepository
         */
        private $contractorDistrictRepository;
        private $occurrenceOrderService;
        /**
         * @var OccurrenceTypeSkillRepository
         */
        private $occurrenceTypeSkillRepository;
        /**
         * @var UserSkillRepository
         */
        private $userSkillRepository;
        /**
         * @var OccurrenceImageService
         */
        private $occurrenceImageService;

        private $workdayProgramsRepository;
        /**
         * @var AddressService
         */
        private $addressService;
        /**
         * @var RoutingService
         */
        private $routingService;

        /**
         * @var OccurrencePdfRepository
         */
        private $occurrencePdfRepository;

        /**
         * OccurrenceService constructor.
         * @param OccurrenceRepository $occurrenceRepository
         * @param OccurrenceClientRepository $occurrenceClientRepository
         * @param OccurrenceTypeRepository $occurrenceTypeRepository
         * @param UserRepository $userRepository
         * @param OccurrenceImageRepository $occurrenceImageRepository
         * @param OccurrenceImageService $occurrenceImageService
         * @param ReallocationRepository $reallocationRepository
         * @param FormGroupRepository $formGroupRepository
         * @param OccurrenceTypeFormRepository $occurrenceTypeFormRepository
         * @param OccurrenceDataBasicRepository $occurrenceDataBasicRepository
         * @param OccurrenceClientPhoneRepository $occurrenceClientPhoneRepository
         * @param ContractorRepository $contractorRepository
         * @param OccurrenceArchiveService $occurrenceArchiveService
         * @param DistrictRepository $districtRepository
         * @param ContractorOccurrenceTypeRepository $contractorOccurrenceTypeRepository
         * @param ContractorDistrictRepository $contractorDistrictRepository
         * @param OccurrenceOrderService $occurrenceOrderService
         * @param OccurrenceTypeSkillRepository $occurrenceTypeSkillRepository
         * @param UserSkillRepository $userSkillRepository
         * @param InterferenceRepository $interferenceRepository
         * @param OccurrenceDataClientRepository $occurrenceDataClientRepository
         * @param PlanOccurrenceRepository $planOccurrenceRepository
         * @param WorkdayProgramsRepository $workdayProgramsRepository
         * @param AddressService $addressService
         * @param RoutingService $routingService
         * @param OccurrencePdfRepository $occurrencePdfRepository;

         */
        public function __construct(
            OccurrenceRepository $occurrenceRepository,
            OccurrenceClientRepository $occurrenceClientRepository,
            OccurrenceTypeRepository $occurrenceTypeRepository,
            UserRepository $userRepository,
            OccurrenceImageRepository $occurrenceImageRepository,
            OccurrenceImageService $occurrenceImageService,
            ReallocationRepository $reallocationRepository,
            FormGroupRepository $formGroupRepository,
            OccurrenceTypeFormRepository $occurrenceTypeFormRepository,
            OccurrenceDataBasicRepository $occurrenceDataBasicRepository,
            OccurrenceClientPhoneRepository $occurrenceClientPhoneRepository,
            ContractorRepository $contractorRepository,
            OccurrenceArchiveService $occurrenceArchiveService,
            DistrictRepository $districtRepository,
            ContractorOccurrenceTypeRepository $contractorOccurrenceTypeRepository,
            ContractorDistrictRepository $contractorDistrictRepository,
            OccurrenceOrderService $occurrenceOrderService,
            OccurrenceTypeSkillRepository $occurrenceTypeSkillRepository,
            UserSkillRepository $userSkillRepository,
            InterferenceRepository $interferenceRepository,
            OccurrenceDataClientRepository $occurrenceDataClientRepository,
            PlanOccurrenceRepository $planOccurrenceRepository,
            WorkdayProgramsRepository $workdayProgramsRepository,
            AddressService $addressService,
            RoutingService $routingService,
            OccurrencePdfRepository $occurrencePdfRepository
            )
        {
            $this->occurrenceRepository = $occurrenceRepository;
            $this->occurrenceClientRepository = $occurrenceClientRepository;
            $this->occurrenceTypeRepository = $occurrenceTypeRepository;
            $this->userRepository = $userRepository;
            $this->occurrenceImageRepository = $occurrenceImageRepository;
            $this->occurrenceImageService = $occurrenceImageService;
            $this->reallocationRepository = $reallocationRepository;
            $this->formGroupRepository = $formGroupRepository;
            $this->occurrenceTypeFormRepository = $occurrenceTypeFormRepository;
            $this->occurrenceDataBasicRepository = $occurrenceDataBasicRepository;
            $this->contractorRepository = $contractorRepository;
            $this->occurrenceClientPhoneRepository = $occurrenceClientPhoneRepository;
            $this->occurrenceArchiveService = $occurrenceArchiveService;
            $this->districtRepository = $districtRepository;
            $this->contractorOccurrenceTypeRepository = $contractorOccurrenceTypeRepository;
            $this->contractorDistrictRepository = $contractorDistrictRepository;
            $this->occurrenceOrderService = $occurrenceOrderService;
            $this->occurrenceTypeSkillRepository = $occurrenceTypeSkillRepository;
            $this->userSkillRepository = $userSkillRepository;
            $this->interferenceRepository = $interferenceRepository;
            $this->occurrenceDataClientRepository = $occurrenceDataClientRepository;
            $this->planOccurrenceRepository = $planOccurrenceRepository;
            $this->workdayProgramsRepository = $workdayProgramsRepository;
            $this->addressService = $addressService;
            $this->routingService = $routingService;
            $this->occurrencePdfRepository = $occurrencePdfRepository;
        }

        public function listOccurences()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceSelectCriteria());
            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            //        $operators = $this->userRepository->all();
            $operators = $this->userRepository->findWhere(["status" => 1]);

            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();

            $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria());
            $occurrence_types = $this->occurrenceTypeRepository->all();
            $contractors = $this->contractorRepository->all();

            $user = new User();

            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.index', compact('occurrences', 'occurrence_types', 'operators', 'occurrence_clients', 'programmers', 'occurrences_all', 'contractors'));
        }

        public function getAllOccurrences()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceSelectCriteria());
            return $this->occurrenceRepository->all();
        }

        public function createOccurrence($occurrence = null, $operador = null, $dataTicket = null)
        {

            if (!\Auth::user()->contractor_id) {
                return redirect()->route('occurrences.index')->with('error', "Apenas empresas têm acesso a criar o item.");
            }

            $contractors = $this->contractorRepository->all();
            $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria());
            $occurrence_types = $this->occurrenceTypeRepository->all();

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();

            $client = '';
            if($dataTicket != null){
                $client = $this->occurrenceClientRepository->find($dataTicket->occurrence_client_id);
            }


            return view('occurrences.create', compact('occurrence_types', 'contractors', 'operators', 'operador', 'occurrence', 'dataTicket', 'client'));
        }


        public function addNewOccurrence(Request $request)
        {
            if (!\Auth::user()->contractor_id) {
                return redirect()->route('occurrences.index')->with('error', "Apenas empresas têm acesso a criar o item.");
            }

            $data = $request->all();

            if(isset($data['ticket']) && !empty($data['ticket'])){
                $obs = "";
                foreach($data['ticket'] as $key => $ticket){
                    if(gettype($ticket) == 'array'){
                        $array = implode('; ', $ticket);
                        $obs.= $key.': '.$array.'; ' ;
                    }else{
                        $obs.= $key.': '.$ticket.'; ';
                    }
                }
            }
            

            $os_before_id = $request->input("os_before_id");

            //Se for cliente novo salva os dados
            if (empty($data["occurrence_client_id"]) || !isset($data["occurrence_client_id"])) {

                //valida os dados do cliente
                $validator = $this->validatorClient($request);
                if ($validator != "ok") {
                    return redirect('admin/occurrences/create')->withErrors($validator)->withInput();
                }

                $occurrence_client = $this->occurrenceClientRepository->create($data);
                $data["occurrence_client_id"] = $occurrence_client->id;
                $data["numero_cliente"] = $occurrence_client->client_number;

                if (isset($data['phones']) && count($data['phones']) > 0 && isset($data["occurrence_client_id"])) {
                    foreach ($data['phones'] as $index => $phone) {
                        $obs = "";
                        if (isset($data['obs'][$index])) {
                            $obs = $data['obs'][$index];
                        }

                        if (!empty(trim($phone))) {
                            $this->occurrenceClientPhoneRepository->create([
                                "occurrence_client_id" => $data["occurrence_client_id"],
                                "phone" => trim($phone),
                                "obs" => $obs
                            ]);
                        }
                    }
                }
            } else {
                $occurrence_client = $this->occurrenceClientRepository->find($data["occurrence_client_id"]);
                $data["numero_cliente"] = $occurrence_client->client_number;
            }


            if (!empty($data["schedule_date"]))
                $data["schedule_date"] = Carbon::createFromFormat('d/m/Y', $data["schedule_date_submit"])->toDateString();


            $data["is_manual"] = 2;
            $data["status"] = 1;
            $data["realized"] = false;
            $data["code_verification"] = rand(1000, 9999);

            if ($os_before_id) {
                $data["os_before_id"] = $os_before_id;
            }

            $data['obs_os'] = $obs;
            $occurrence = $this->occurrenceRepository->create($data);

            if(isset($data['ticket_id']) && !empty($data['ticket_id'])){
                $ticket = Ticket::find($data['ticket_id']);
                $ticket->status = 3; 
                $ticket->occurrence_id = $occurrence->id; 
                $ticket->save(); 
            }

            /*casa tenha anexo, envia o arquivo para OccurrenceArchiveController para ser tratado e
            anexado*/

            if ($anexos['anexos'] = $request->file('anexos')) {
                $anexos['occurrence'] = $occurrence->id;
                $anexos['occurrence_uuid'] = $occurrence->uuid;
                $this->occurrenceArchiveService->addAnexoOs($anexos);
            }

            $dataForms = $request->input('forms', []);

            $dataForms = array_merge($dataForms, $occurrence->occurrence_type->forms->pluck("id")->toArray());

            //Associa os forms a OS
            $occurrence->forms()->sync($dataForms);

            return redirect()->route('occurrences.index')->with('message', 'Item criado com sucesso.');
        }

        public function showOccurence($occurrence)
        {
            $occurrence->check_in_lat = ($occurrence->check_in_lat == "0.0") ? null : $occurrence->check_in_lat;
            $occurrence->check_in_long = ($occurrence->check_in_long == "0.0") ? null : $occurrence->check_in_long;

            $occurrence->check_out_lat = ($occurrence->check_out_lat == "0.0") ? null : $occurrence->check_out_lat;
            $occurrence->check_out_long = ($occurrence->check_out_long == "0.0") ? null : $occurrence->check_out_long;

            $form_groups = $this->formGroupRepository->all();
            
            $dataForms = array();

            if($occurrence->ticket_id != null){
                $ticket = Ticket::find($occurrence->ticket_id);
                $ticketData = json_decode($ticket->ticketData, true);
                $data = json_decode($ticketData['data'], true);
                $dataForms = $data['forms'][0]['sections'];
            }
            

            return view('occurrences.show', compact('occurrence', 'form_groups', 'dataForms'));
        }

        public function showOccurenceClient($occurrence)
        {
            $occurrence->check_in_lat = ($occurrence->check_in_lat == "0.0") ? null : $occurrence->check_in_lat;
            $occurrence->check_in_long = ($occurrence->check_in_long == "0.0") ? null : $occurrence->check_in_long;

            $occurrence->check_out_lat = ($occurrence->check_out_lat == "0.0") ? null : $occurrence->check_out_lat;
            $occurrence->check_out_long = ($occurrence->check_out_long == "0.0") ? null : $occurrence->check_out_long;


            $traking = [];

            if ($occurrence->occurrence_client && (empty($occurrence->occurrence_client->lat) || empty($occurrence->occurrence_client->lng))) {

                //Verifica se já tem no banco
                $client_cood = $this->addressService->getByAddress($occurrence->occurrence_client->address . "," . $occurrence->occurrence_client->number . "," . $occurrence->occurrence_client->city);

                if ($client_cood) {
                    $traking["client_lat"] = $client_cood->lat;
                    $traking["client_lng"] = $client_cood->lng;
                } else {

                    $startPoint = getCoordsAddressGMAPS($occurrence->occurrence_client->address . "," . $occurrence->occurrence_client->number . "," . $occurrence->occurrence_client->city);
                    $this->routingService->salveRouting(null, [['address' => $occurrence->occurrence_client->address . "," . $occurrence->occurrence_client->number . "," . $occurrence->occurrence_client->city]], [$startPoint], 2);
                    $this->addressService->saveAddress($occurrence->occurrence_client->address . "," . $occurrence->occurrence_client->number . "," . $occurrence->occurrence_client->city, $startPoint['lat'], $startPoint['lng']);

                    $traking["client_lat"] = $startPoint['lat'];
                    $traking["client_lng"] = $startPoint['lng'];

                }
            } else {
                $traking["client_lat"] = null;
                $traking["client_lng"] = null;
            }

            return view('occurrences.show_client', compact('occurrence', 'traking'));
        }

        public function editOccurrence($occurrence)
        {
            $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria());
            $occurrence_types = $this->occurrenceTypeRepository->all();

            $contractors = $this->contractorRepository->all();

            $occurrence->schedule_date = Carbon::parse($occurrence->schedule_date)->format("d/m/Y");

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();

            return view('occurrences.edit', compact('occurrence', 'occurrence_types', 'contractors', 'operators'));
        }

        public function executeOccurrence($occurrence)
        {

            $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria());
            $occurrence_types = $this->occurrenceTypeRepository->all();

            $contractors = $this->contractorRepository->all();

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();

            $this->interferenceRepository->pushCriteria(new InterferenceCriteria());
            $interferences = $this->interferenceRepository->all();

            $occurrence_forms = $occurrence->occurrence_forms;


            return view('occurrences.execute', compact('occurrence', 'occurrence_types', 'contractors', 'operators', 'occurrence_forms', 'interferences'));
        }


        public function createExecute($request, $occurrence)
        {
            $requestData = $request->all();
            //            dd($requestData);

            try {
                /*
                    Atualizar dados da OS como status
                */

                if (isset($requestData['chekin']) && !empty($requestData['chekin'])) {
                    $chekin = $requestData['chekin'];
                } else {
                    $chekin = null;
                }

                if (isset($requestData['obs_os']) && !empty($requestData['obs_os'])) {
                    $obs_os = $requestData['obs_os'];
                } else {
                    $obs_os = null;
                }

                $nameFile = "log_json_" . date("Ymd") . "_" . $occurrence->id . ".log";

                Storage::disk('public')->prepend('log/' . $nameFile, json_encode($requestData));
                $path = Storage::disk('public')->path('log/' . $nameFile);
                $url = "";
                if (is_file($path)) {
                    //sobe para S3
                    $base = env('S3_PATH', 'centralmob/gns_staging/');
                    $archive_name = $base . "archives/os/" . $occurrence->id . '.txt';
                    $s3Client = Storage::disk('s3');
                    $contents = File::get($path);
                    $s3Client->put($archive_name, $contents);
                    $url = $s3Client->url($archive_name);
                    //deleta arquivo
                    File::delete($path);
                }

                $dataOccurrenceUpdate = [
                    'check_in' => $chekin,
                    'check_out' => Carbon::now(),
                    'status' => 2,
                    'manual_execution' => 1,
                    'execute_by' => Auth::user()->id,
                    'obs_os' => $obs_os,
                    'url' => $url
                ];

                $this->occurrenceRepository->update($dataOccurrenceUpdate, $occurrence->id);

                /*
                    Atualizar dados do cliente acompanhante
                */
                if (isset($requestData['cliente']) && !empty($requestData['cliente'])) {
                    $occurrence_cliente = $requestData['cliente'];
                    $occurrence_cliente['occurrence_id'] = $occurrence->id;
                    $this->occurrenceDataClientRepository->updateOrCreate($occurrence_cliente, $occurrence_cliente);
                };
                /*
                    Atualizar dados da interferencia
                */
                if (isset($requestData['interferences']) && !empty($requestData['interferences'])) {
                    $requestData['interferences'] = array_fill_keys($requestData['interferences'], array(
                        'contractor_id' => \Auth::user()->contractor_id,
                    ));

                    $occurrence->interferences()->detach();
                    $occurrence->interferences()->sync($requestData['interferences']);

                }


                /*
                    Salvar dados do form dinamico
                */
                if (Auth::user()->contractor_id) {
                    $contractor_id = Auth::user()->contractor_id;
                } else {
                    $contractor_id = $occurrence->contractor_id;
                }
                $data = [
                    "contractor_id" => $contractor_id,
                    "occurrence_id" => $occurrence->id,
                    "occurrence_uuid" => $occurrence->uuid
                ];

                $json = [];

                if (isset($requestData['form']) && !empty($requestData['form'])) {
                    $json['forms'] = $requestData['form'];
                }


                //Procura fotos
                if (isset($json['forms']) && !empty($json['forms'])) {
                    foreach ($json['forms'] as $fkey => $form) {
                        if (isset($form['sections']) && !empty($form['sections'])) {
                            foreach ($form['sections'] as $skey => $section) {
                                if (isset($section['form_fields']) && !empty($section['form_fields'])) {
                                    foreach ($section['form_fields'] as $ffkey => $form_field) {
                                        if (isset($form_field['type_field']) && !empty($form_field['type_field']) && isset($form_field['value']) && !empty($form_field['value'])) {
                                            if ($form_field['type_field'] == 5 || $form_field['type_field'] == 7) {
                                                // fazer upload com o campo value
                                                $url = $this->uploadS3($form_field['value'], $occurrence->id);
//                                                $json['forms'][$fkey]['sections'][$skey]['form_fields'][$ffkey]['value'] = $url;
                                                $imageData = [
                                                    'occurrence_id' => $occurrence->id,
                                                    'url' => $url,
                                                    'reference' => pathinfo($form_field['value']->getClientOriginalName(), PATHINFO_FILENAME),
                                                    'form_id' => $form['id'],
                                                    'form_field_id' => $form_field['id']
                                                ];
                                                $this->occurrenceImageRepository->create($imageData);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                //Valida checkbox vazio
                if (isset($json['forms']) && !empty($json['forms'])) {
                    foreach ($json['forms'] as $fkey => $form) {
                        if (isset($form['sections']) && !empty($form['sections'])) {
                            foreach ($form['sections'] as $skey => $section) {
                                if (isset($section['form_fields']) && !empty($section['form_fields'])) {
                                    foreach ($section['form_fields'] as $ffkey => $form_field) {
                                        if (isset($form_field['type_field']) && !empty($form_field['type_field'])) {
                                            if ($form_field['type_field'] == 1 && !isset($form_field['value'])) {
                                                $json['forms'][$fkey]['sections'][$skey]['form_fields'][$ffkey]['value'] = null;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $data['json'] = $json;

                $occurrenceDynamo = new OccurrenceDynamo();
                $occurrenceDynamo->create($data);

                return redirect()->route('occurrences.show', $occurrence->uuid)->with('message', 'Os executada com sucesso.');

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Não foi possível executar a OS selecionada. Linha: ' . $e->getLine() . ' - Mensagem: ' . $e->getMessage());
            }
        }

        public function updateOccurrence($occurrenceRequest, $occurrence)
        {
            $data = $occurrenceRequest->all();

            if (isset($data['nao_realizado']) && $data['nao_realizado'] == "") {
                $data['nao_realizado'] = null;
            }
            if ($occurrence->status == 1) {
                if (!empty($data["schedule_date"])) {
                    $data["schedule_date"] = Carbon::createFromFormat('d/m/Y', $data["schedule_date"])->toDateString();
                    $data["order_flag"] = 0;
                }
            }

            //Se for cliente novo salva os dados
            if (!isset($data["occurrence_client_id"]) || empty($data["occurrence_client_id"])) {

                //valida os dados do cliente
                $validator = $this->validatorClient($occurrenceRequest);
                if ($validator != "ok") {
                    return redirect('admin/occurrences/create')->withErrors($validator)->withInput();
                }

                $occurrence_client = $this->occurrenceClientRepository->create($data);
                $data["occurrence_client_id"] = $occurrence_client->id;
                $data["numero_cliente"] = $occurrence_client->client_number;

                if (isset($data['phones']) && count($data['phones']) > 0 && isset($data["occurrence_client_id"])) {
                    foreach ($data['phones'] as $index => $phone) {
                        $obs = "";
                        if (isset($data['obs'][$index])) {
                            $obs = $data['obs'][$index];
                        }

                        if (!empty(trim($phone))) {
                            $this->occurrenceClientPhoneRepository->create([
                                "occurrence_client_id" => $data["occurrence_client_id"],
                                "phone" => trim($phone),
                                "obs" => $obs
                            ]);
                        }
                    }
                }
            }

            if (!isset($data['numero_cliente']) || $data['numero_cliente'] = "") {
                $occurrence_client = $this->occurrenceClientRepository->find($data["occurrence_client_id"]);
                $data["numero_cliente"] = $occurrence_client->client_number;
            }

            if ($occurrence->status == 1 && ((!empty($occurrence->operator_id) && $occurrence->operator_id != $data["operator_id"]) || (!empty($occurrence->schedule_date) && $occurrence->schedule_date != $data["schedule_date"]))) {
                //REGRA PARA COLOCAR NO BANCO DE REALLOCATIONS OS DADOS CORRETOS COM O STATUS CORRETO
                $reallocation = array(
                    "occurrence_id" => $occurrence->id,
                    "operator_id" => $occurrence->operator_id,
                    "status" => 0,
                    // 0 = Não notificado
                );
                $this->reallocationRepository->create($reallocation);

                //Zera o status
                $data["download_at"] = null;
                // deleta valor da ordencação
                $data["order_client"] = null;
                $data["order_flag"] = 0;
            }


            //Atualiza Occurence
            $occurrence = $this->occurrenceRepository->update($data, $occurrence->id);

            if ($occurrence->occurrence_data_basic) {
                $occurrence->occurrence_data_basic->save();
            }

            if (isset($data['occurrence_data_basic']["obs_empreiteira"]) && !empty($data['occurrence_data_basic']["obs_empreiteira"])) {
                $this->occurrenceDataBasicRepository->update(["obs_empreiteira" => $data['occurrence_data_basic']['obs_empreiteira']], $occurrence->occurrence_data_basic->id);
            }

            $dataForms = $occurrenceRequest->input('forms', []);

            $dataForms = array_merge($dataForms, $occurrence->occurrence_type->forms->pluck("id")->toArray());

            $occurrence->forms()->sync($dataForms);

            return redirect()->route('occurrences.show', $occurrence->uuid)->with('message', 'Item atualizado com sucesso.');
        }

        public function editClient($occurrence, $request)
        {
            $data = $request->all();
            $occurrence = $this->occurrenceRepository->update($data, $occurrence->id);

            return redirect()->route('occurrences.show', $occurrence->uuid)->with('message', 'Item atualizado com sucesso.');
        }

        public function deleteOs($occurrence)
        {
            //Deleta a os principal

            return redirect()->back()->with('error', 'Não permitido deletar OS.');

            /*

            $this->deleteOsRecursive($occurrence->id);
            return redirect()->route('occurrences.index')->with('message', 'Item excluído com sucesso.');

            */
        }

        public function listPending()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrencePendingCriteria());

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            //        $operators = $this->userRepository->all();
            $operators = $this->userRepository->findWhere(["status" => 1]);
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();
            $motivos = CancelamentoStatus::get();


            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $contractors = $this->contractorRepository->all();

            $user = new User();

            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.pending', compact('occurrences', 'occurrence_clients', 'operators', 'occurrence_types', 'programmers', 'occurrences_all', 'motivos', 'contractors'));
        }

        public function listNotExecuted()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceNotExecutedCriteria());

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->findWhere(["status" => 1]);
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();
            $motivos = CancelamentoStatus::get();


            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $contractors = $this->contractorRepository->all();

            $user = new User();

            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.not_executed', compact('occurrences', 'occurrence_clients', 'operators', 'occurrence_types', 'programmers', 'occurrences_all', 'motivos', 'contractors'));
        }

        public function statusScheduleList()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceStatusScheduleCriteria());

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->findWhere(["status" => 1]);
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();
            $motivos = CancelamentoStatus::get();


            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $contractors = $this->contractorRepository->all();

            $user = new User();

            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.status_schedule', compact('occurrences', 'occurrence_clients', 'operators', 'occurrence_types', 'programmers', 'occurrences_all', 'motivos', 'contractors'));
        }

        public function listUnassigned()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceUnassignedCriteria());
            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            //        $operators = $this->userRepository->all();
            $operators = $this->userRepository->findWhere(["status" => 1]);

            //        $this->userRepository->getByCriteria(new ProgrammerSelectCriteria());

            $user = new User();

            $programmers = $user->scopeRole(5)->get();

            $occurrence_types = $this->occurrenceTypeRepository->all();
            $contractors = $this->contractorRepository->all();

            return view('occurrences.unassigned', compact('occurrences', 'occurrence_clients', 'operators', 'occurrence_types', 'programmers', 'occurrences_all', 'contractors'));
        }

        public function listClosed()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceClosedCriteria());

            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();


            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();

            $user = new User();
            $programmers = $user->scopeRole(5)->get();
            $contractors = $this->contractorRepository->all();

            return view('occurrences.closed', compact('occurrences', 'occurrence_clients', 'occurrence_types', 'operators', 'programmers', 'occurrences_all', 'contractors'));
        }

        public function listToApproved()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceToApprovedCriteria());

            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();


            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();
            $contractors = $this->contractorRepository->all();

            $user = new User();
            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.financial.to_approved', compact('occurrences', 'occurrence_clients', 'occurrence_types', 'operators', 'programmers', 'occurrences_all', 'contractors'));
        }

        public function listApproved()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceApprovedCriteria());

            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();


            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();
            $contractors = $this->contractorRepository->all();

            $user = new User();
            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.financial.approved', compact('occurrences', 'occurrence_clients', 'occurrence_types', 'operators', 'programmers', 'occurrences_all', 'contractors'));
        }


        public function listClosedUnsolved()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceClosedUnsolvedCriteria());

            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();
            $motivos = CancelamentoStatus::get();


            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            //        $operators = $this->userRepository->all();
            $operators = $this->userRepository->findWhere(["status" => 1]);
            $contractors = $this->contractorRepository->all();

            $user = new User();
            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.closed_unsolved', compact('occurrences', 'occurrence_clients', 'occurrence_types', 'operators', 'programmers', 'occurrences_all', 'motivos', 'contractors'));
        }

        public function associateOsOperator($request)
        {
            $data = $request->all();

            //Verifica se a ocorrência existe
            if (isset($data["occurrence_id"]) && !empty($data["occurrence_id"])) {
                $occurrence = $this->occurrenceRepository->find($data["occurrence_id"]);
            } else {
                return redirect()->route('occurrences.index')->with('error', 'Informação da OS não enviada');
            }

            //verifica se está trocando operador ou reagendando
            if (empty($data["operator_id"]) && (!isset($data["obs_atendimento"]) || empty($data["obs_atendimento"])))
                return redirect()->route('occurrences.show', $occurrence->uuid)->with('error', 'Selecione Reatribuir OS ou Confirmar Atendimento');

            if ($occurrence->operator_id != $data["operator_id"]) {
                //Zera o status
                $data["download_at"] = null;
                $data["status"] = 1;
                $data["reagendar"] = null;

                //REGRA PARA COLOCAR NO BANCO DE REALLOCATIONS OS DADOS CORRETOS COM O STATUS CORRETO
                if (!empty($occurrence->operator_id)) {
                    $reallocation = array(
                        "occurrence_id" => $data["occurrence_id"],
                        "operator_id" => $occurrence->operator_id,
                        "status" => 0,
                        // 0 = Não notificado
                    );
                    $this->reallocationRepository->create($reallocation);
                }
            }

            if (isset($data["operator_id"]) && empty($data["operator_id"])) {
                $data["operator_id"] = null;
            }

            if (isset($data["confirm_agendamento"]) && !empty($data["confirm_agendamento"]) && $data["confirm_agendamento"] == "on") {
                $data["confirm_agendamento"] = 1;
                $data["confirm_schedule_user_id"] = Auth::user()->id;
            }

            $this->occurrenceRepository->update($data, $occurrence->id);

            return redirect()->route('occurrences.show', $occurrence->uuid)->with('message', 'OS atualizada com sucesso.');
        }

        public function statusSchedule($request)
        {
            $data = $request->all();

            $this->occurrenceRepository->update([
                'status_schedule' => $data['status'],
                "status_schedule_date" => Carbon::now()
            ], $data['occurrence_id']);

            return response()->json('success');
        }

        public function associateOssOperator($request)
        {
            $data = $request->all();

            $operator_id = $data["operator_id"];
            $occurrences_id = $data["ids"];
            $occurrences_id = explode(",", $occurrences_id);
            $occurrences = $this->occurrenceRepository->scopeQuery(function ($query) {
                return $query->orderBy('priority', 'desc');
            })->findWhereIn("id", $occurrences_id);

            $erro = array();

            foreach ($occurrences as $occurrence) {
                $new_request = [];
                if ($occurrence->operator_id != $data["operator_id"]) {
                    //REGRA PARA COLOCAR NO BANCO DE REALLOCATIONS OS DADOS CORRETOS COM O STATUS CORRETO
                    if (!empty($occurrence->operator_id)) {
                        $reallocation = array(
                            "occurrence_id" => $occurrence->id,
                            "operator_id" => $occurrence->operator_id,
                            "status" => 0,
                            // 0 = Não notificado
                        );
                        $this->reallocationRepository->create($reallocation);
                    }

                    //Zera o status
                    $new_request["download_at"] = null;
                    // deleta valor da ordencação
                    $new_request["order_client"] = null;
                    $new_request["order_flag"] = 0;
                }

                if ($operator_id == "X") {
                    $new_request["operator_id"] = null;
                    $new_request["download_at"] = null;
                    //Zera o status
                    $new_request["status"] = 1;
                    $new_request["reagendar"] = null;

                } else if ($operator_id == "auto") {
                    //Busca de forma automática de acordo com os parâmetros da OS x Skill x User x jornada

                    $occurrence_type_skills = $this->occurrenceTypeSkillRepository->findWhere(["occurrence_type_id" => $occurrence->occurrence_type_id], ["skill_id"]);
                    if ($occurrence_type_skills->count()) {

                        //Busca os operadores com as skills necessárias
                        $operator_skills = $this->userSkillRepository->findWhereIn("skill_id", [$occurrence_type_skills->implode('skill_id', ',')]);

                        if ($operator_skills->count()) {

                            foreach ($operator_skills as $operator_skill) {

                                /**
                                 * Verificar se técnico tem jornada associado
                                 *      se não tiver, considerear 7 trabalhada
                                 * Verificar se a data de schedule da os bate com o dia da jornada do técnico
                                 *      verificar o tempo total de os para data da os em questão
                                 */

                                $return_operator = $this->selectOperator($occurrence, $operator_skill->user);
                                if ($return_operator["status"] == 2) {
                                    continue;
                                } else {
                                    $new_request["operator_id"] = $return_operator["operator_id"];
                                    break;
                                }
                            }

                            //Não conseguiu associar pra ninguém
                            if (!isset($new_request["operator_id"])) {
                                $erro[] = $occurrence->id;
                                unset($new_request);
                                continue;
                            }

                        } else {

                            $erro[] = $occurrence->id;
                            unset($new_request);
                            continue;
                        }
                    } else {
                        //NÃO PRESICA DE SKILL
                        $operators = $this->userRepository->skipCriteria()->pushCriteria(new OperatorSelectCriteria())->all()->shuffle();
                        if ($operators) {

                            foreach ($operators as $operator) {

                                //Não tem necessidade de Skills
                                $return_operator = $this->selectOperator($occurrence, $operator);
                                if ($return_operator["status"] == 2) {
                                    continue;
                                } else {
                                    $new_request["operator_id"] = $return_operator["operator_id"];
                                }
                                break;
                            }

                            //Não conseguiu associar pra ninguém
                            if (!isset($new_request["operator_id"])) {
                                $erro[] = $occurrence->id;
                                unset($new_request);
                                continue;
                            }
                        } else {
                            //NÃO TEM OPERADOR
                            $erro[] = $occurrence->id;
                            unset($new_request);
                            continue;
                        }
                    }
                } else {
                    //ATRIBUIÇÃO NORMAL
                    $new_request["operator_id"] = $operator_id;
                    // verifica a quantidade de OS para salvar na ordenação
                    $new_request["order_client"] = $this->occurrenceRepository->findWhere([
                        "operator_id" => $operator_id,
                        'schedule_date' => Carbon::today()
                    ])->count();
                }

                $this->occurrenceRepository->update($new_request, $occurrence->id);
                unset($new_request);
            }


            if (count($erro) > 0) {
                if (count($erro) < count($occurrences)) {
                    return response()->json([
                        'retorno' => 2,
                        'mensagem' => 'Algumas OSs não puderam ser associadas de forma automática, segue IDs (' . implode(", ", $erro) . ')'
                    ]);
                } else {
                    return response()->json([
                        'retorno' => 2,
                        'mensagem' => 'Houve OS que não pode ser associada de forma automática, segue IDs (' . implode(", ", $erro) . ')'
                    ]);
                }
            } else {
                return response()->json([
                    'retorno' => 1,
                    'mensagem' => 'OS atribuída(s) com sucesso!'
                ]);
            }
        }

        public function exportOs($id)
        {
            $occurrence = $this->occurrenceRepository->find($id);
            //        dd($occurrence);

            Excel::create('Export OS', function ($excel) use ($occurrence) {
                $excel->sheet('Sheet 1', function ($sheet) use ($occurrence) {
                    $sheet->fromArray($occurrence, null, 'A1', true);
                });
            })->download('xlsx');

            return "Exportado";

            //        return view('occurrences.show', compact('occurrence','operators','occurrence_specific'));

        }

        private function selectOperator($occurrence, $operator)
        {
            //Considerando jornada de 7h
            $work = Carbon::createFromTime(7, 0, 0)->format("H:i:s");

            if ($operator->workday) {

                $day = Carbon::parse($occurrence->schedule_date)->dayOfWeek;

                $program = $operator->workday->workday_programs()->where('day', '=', $day + 1)->first();

                $hour = $program->hour;

                if ($hour == 0) {
                    return ["status" => 2];
                }
                $work = Carbon::createFromTime($hour, 0, 0)->format("H:i:s");

            }


            //Pegando o tempo de total de OS no dia para o tecnico
            $operator_occurrences_time = $operator->occurrences()->join("occurrence_types", 'occurrences.occurrence_type_id', 'occurrence_types.id')->where('occurrences.schedule_date', '=', $occurrence->schedule_date)->select(\DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(occurrence_types.average_time))) as timetotal'))->first();

            if ($operator_occurrences_time && $operator_occurrences_time->timetotal != null) {
                $timeTotal = Carbon::parse($operator_occurrences_time->timetotal);

                if ($timeTotal->format("H:i:s") >= $work) {
                    $erro[] = $occurrence->id;
                    return ["status" => 2];
                }
                //tempo médio de execução da OS
                $time = explode(":", $occurrence->occurrence_type->average_time);
                $sum = $timeTotal->addHours($time[0])->addMinutes($time[1])->addSeconds($time[2])->format("H:i:s");


                if ($sum >= $work) {
                    $erro[] = $occurrence->id;
                    return ["status" => 2];
                }
                //            dd($work, $timeTotal->format("H:i:s"), $sum);
            }


            //Se passou por todos os IFs, associa e stop o foreach
            return array(
                "status" => 1,
                "operator_id" => $operator->id
            );
        }

        private function validatorClient($request)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);
            if ($validator->fails()) {
                return $validator;
            } else {
                return "ok";
            }
        }

        public function operatorAjax($operator)
        {
            return $this->occurrenceRepository->scopeQuery(function ($query) {
                return $query->whereBetween('schedule_date', [
                    Carbon::now()->subMonth()->format('Y-m-d'),
                    Carbon::now()->format('Y-m-d'),
                ]);
            })->findWhere(["operator_id" => $operator->id], ["id"])->all();
        }

        private function deleteOsRecursive($occurrence_id)
        {

            $occurrence = $this->occurrenceRepository->find($occurrence_id);

            //remove a imagens
            if (count($occurrence->occurrence_images) > 0) {
                foreach ($occurrence->occurrence_images as $data) {
                    $this->occurrenceImageRepository->delete($data->id);
                    //Deleta imagem do S3
                    $s3Client = Storage::disk('s3');
                    $s3Client->delete($data->url);
                }
            }

            //remove a os
            $occurrence->delete();

        }

        public function showUploadImagem($occurrence)
        {
            return view("occurrences.upload", compact("occurrence"));
        }

        public function uploadImagem($request, $occurrence)
        {
            $erro = 0;
            $fileNameExtensionError = [];
            $extensionError = 0;
            $files = $request->file("foto_extra");
            $data = $request->all();

            $occurrenceId = (is_object($occurrence)) ? $occurrence->id : $data['occurrence'];
            $occurrenceUuid = (is_object($occurrence)) ? $occurrence->uuid : $data['occurrence_uuid'];

            $estensions = [
                'jpg',
                'jpeg',
                'png'
            ];

            if ($request->hasFile("foto_extra")) {
                foreach ($files as $file) {
                    //uploadSimpleUniqueImagemS3
                    $estension = $file->getClientOriginalExtension();

                    if (!in_array($estension, $estensions)) {
                        $fileNameExtensionError[] = $file->getClientOriginalName();
                        $extensionError++;
                        continue;
                    }

                    $url = $this->occurrenceImageService->uploadSimpleUniqueImagemS3($file, $occurrenceId, "foto_extra");
                    $this->occurrenceImageService->saveOccurrenceImagePublic($url, $occurrenceId, "foto_extra");
                }
            } else {
                $erro++;
            }

            if ($erro > 0) {
                // sending back with error message.
                Session::flash('error', 'Erro ao efetuar o upload');
                return redirect()->route('occurrences.update', $occurrenceUuid)->with('error', 'Erro ao efetuar o upload');
            } else {

                if ($extensionError > 0) {
                    Session::flash('erro', 'Erro ao efetuar o upload');
                    return redirect()->route('occurrences.show', $occurrenceUuid)->with('error', 'Erro ao efetuar o upload. As imgens ' . implode(',', $fileNameExtensionError)) . 'não foram enviadas';
                }
                Session::flash('message', 'Fotos enviadas com sucesso');
                return redirect()->route('occurrences.show', $occurrenceUuid)->with('message', 'Fotos enviadas com sucesso');
            }
        }

        public function pdfGenerate($occurrence, $image = '', $form_id = null)
        {
            $force = request()->input('force');
            if($occurrence->status != 1){

               if($image == 1){
                   if($form_id){
                       $pdf = $occurrence->pdfs()->where('type', 2)->where('form_id', $form_id)->orderBy('id', 'desc')->first();
                       $data["form_id"] = $form_id;

                   } else {
                       $pdf = $occurrence->pdfs()->where('type', 2)->whereNull('form_id')->orderBy('id', 'desc')->first();
                   }

                   if(!$pdf || $force == 1) {
                       $pdfFile = $this->gerarPdf($occurrence);
                       $url = $this->uploadPdfS3($pdfFile, $occurrence->id, $occurrence->id . "_sem_imagem");

                       $data["url"] = $url;
                       $data["type"] = 2;
                       $data["occurrence_id"] = $occurrence->id;

                       if($pdf){
                            $this->occurrencePdfRepository->update($data, $pdf->id);
                       } else {
                           $this->occurrencePdfRepository->create($data);
                       }

                       return redirect()->to($url);
                   } else {

                       return redirect()->to($pdf->url);

                   }

                }else{

                   if($form_id){
                        $pdf = $occurrence->pdfs()->where('type', 1)->where('form_id', $form_id)->orderBy('id', 'desc')->first();
                        $data["form_id"] = $form_id;

                   } else {
                       $pdf = $occurrence->pdfs()->where('type', 1)->whereNull('form_id')->orderBy('id', 'desc')->first();
                   }

                   if(!$pdf || $force == 1) {
                       $pdfFile = $this->gerarPdf($occurrence);
                       $url = $this->uploadPdfS3($pdfFile, $occurrence->id, $occurrence->id . "_com_imagem");

                       $data["url"] = $url;
                       $data["type"] = 1;
                       $data["occurrence_id"] = $occurrence->id;

                       if($pdf){
                           $this->occurrencePdfRepository->update($data, $pdf->id);
                       } else {
                           $this->occurrencePdfRepository->create($data);
                       }

                       return redirect()->to($url);
                   } else {
                       return redirect()->to($pdf->url);
                   }
                }
           }

           return PDF::loadFile(str_replace('admin/occurrences', '', request()->url()))->inline($occurrence->id . '.pdf');
        }

        public function sendMail($occurrence)
        {
            $occurrence->check_in_lat = ($occurrence->check_in_lat == "0.0") ? null : $occurrence->check_in_lat;
            $occurrence->check_in_long = ($occurrence->check_in_long == "0.0") ? null : $occurrence->check_in_long;

            $occurrence->check_out_lat = ($occurrence->check_out_lat == "0.0") ? null : $occurrence->check_out_lat;
            $occurrence->check_out_long = ($occurrence->check_out_long == "0.0") ? null : $occurrence->check_out_long;

            $form_groups = $this->formGroupRepository->all();

            return view('mail.occurrence', compact('occurrence', 'form_groups'));
        }

        public function removeFile($request)
        {
            $data = $request->all();
            try {

                $this->occurrenceImageRepository->delete($data["id"]);
                return response()->json([
                    'retorno' => 1,
                    'mensagem' => 'Arquivo apagado com sucesso!'
                ]);

                /*
                //Deleta imagem do S3
                $s3Client = Storage::disk('s3');
                $url_provisoria = str_replace("https://" . $this->aws_bucket . ".s3." . $this->aws_default_region . ".amazonaws.com/", "", $data["url"]);

                if ($s3Client->delete($url_provisoria)) {
                    $this->occurrenceImageRepository->delete($data["id"]);
                    return response()->json([
                        'retorno' => 1,
                        'mensagem' => 'Arquivo apagado com sucesso!'
                    ]);
                } else {
                    return response()->json([
                        'retorno' => 2,
                        'mensagem' => 'O arquivo não pode ser apagado do servidor'
                    ]);
                }
                */
            } catch (Exception $e) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => $e->getMessage()
                ]);
            }
        }

        public function listToAdjust()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceToAdjustCriteria());

            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();


            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();
            $contractors = $this->contractorRepository->all();

            $user = new User();
            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.financial.to_adjust', compact('occurrences', 'occurrence_clients', 'occurrence_types', 'operators', 'programmers', 'occurrences_all', 'contractors'));

        }


        public function listAdjusted()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceAdjustedCriteria());

            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();


            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();
            $contractors = $this->contractorRepository->all();

            $user = new User();
            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.financial.adjusted', compact('occurrences', 'occurrence_clients', 'occurrence_types', 'operators', 'programmers', 'occurrences_all', 'contractors'));
        }

        public function listDisapproved()
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceDisapprovedCriteria());

            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();
            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();
            $occurrence_types = $this->occurrenceTypeRepository->all();


            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();
            $contractors = $this->contractorRepository->all();

            $user = new User();
            $programmers = $user->scopeRole(5)->get();

            return view('occurrences.financial.disapproved', compact('occurrences', 'occurrence_clients', 'occurrence_types', 'operators', 'programmers', 'occurrences_all', 'contractors'));
        }

        public function planOSCreate()
        {
            //Pega todas as configurações de plano
            $planOccurrences = $this->planOccurrenceRepository->pushCriteria(new PlanOccurrenceCreateCriteria())->all();

            //foreach nas configs
            foreach ($planOccurrences as $planOccurrence) {

                if ($planOccurrence->date_start <= Carbon::today()->format("Y-m-d") && (is_null($planOccurrence->date_finish) || $planOccurrence->date_finish > Carbon::today()->format("Y-m-d"))) {

                    //Verifica se já tem OS

                    if ($planOccurrence->occurrences->count()) {

                        $occurrence = $this->occurrenceRepository->pushCriteria(new OccurrencePlanOccurrenceCriteria($planOccurrence))->first();

                        //criando novas os se passou a data de criar ou é hoje
                        if ($occurrence && (Carbon::createFromFormat("Y-m-d", $occurrence->schedule_date)->diffInDays(Carbon::today()->addDay()->format("Y-m-d"), false) >= $planOccurrence->schedule) && (Carbon::createFromFormat("Y-m-d", $occurrence->schedule_date) != Carbon::today()->format("Y-m-d"))) {

                            if ($planOccurrence->weekend == 0 && Carbon::today()->isWeekend()) { //não pode final de semana
                                $expectedDate = (Carbon::today()->format('l') == 'Saturday') ? Carbon::today()->addDay(2) : Carbon::today()->addDay(1);
                            } else {
                                $expectedDate = Carbon::now();
                            }

                            $data = [
                                'schedule_date' => $expectedDate,
                                'priority' => $occurrence->priority,
                                'occurrence_type_id' => $occurrence->occurrence_type_id,
                                'operator_id' => ($planOccurrence->operator_id) ? $planOccurrence->operator_id : null,
                                'occurrence_client_id' => $occurrence->occurrence_client_id,
                                'contractor_id' => $occurrence->contractor_id,
                                'plan_occurrence_id' => $planOccurrence->id,
                                'status' => 1
                            ];

                            $this->occurrenceRepository->create($data);
                        }

                    } else {
                        //Cria primeira OS

                        $data = [
                            'schedule_date' => Carbon::now(),
                            'priority' => 2,
                            //Normal
                            'occurrence_type_id' => $planOccurrence->occurrence_type_id,
                            'operator_id' => ($planOccurrence->operator_id) ? $planOccurrence->operator_id : null,
                            'occurrence_client_id' => $planOccurrence->occurrence_client_id,
                            'contractor_id' => $planOccurrence->contractor_id,
                            'plan_occurrence_id' => $planOccurrence->id,
                            'status' => 1
                        ];

                        $this->occurrenceRepository->create($data);
                    }

                }
            }
        }

        public function storeAjax($occurrenceRequest)
        {
            if (!\Auth::user()->contractor_id) {
                return redirect()->route('occurrences.index')->with('error', "Apenas empresas têm acesso a criar o item.");
            }

            $data = $occurrenceRequest->all();

            $occurrence_client = $this->occurrenceClientRepository->find($data["occurrence_client_id"]);
            $data["numero_cliente"] = $occurrence_client->client_number;

            $data["is_manual"] = 2;
            $data["status"] = 1;
            $data["realized"] = false;
            $data["code_verification"] = rand(1000, 9999);


            $occurrence = $this->occurrenceRepository->create($data);

            if($occurrence){
                return response()->json([
                    "retorno" => 1,
                    "mensagem" => "OS cadastrada com sucesso"
                ]);
            }else{
                return response()->json([
                    "retorno" => 2,
                    "mensagem" => "Ocorreu um erro na tentativa de cadastrar OS"
                ]);
            }
        }

        public function updateAjax($request)
        {
            try{
                $data = [
                    'operator_id' => $request->operator_id,
                    'schedule_time'=> $request->schedule_time,
                ];

                $this->occurrenceRepository->update($data, $request->occurrence_id);

                return response()->json([
                    "retorno" => 1,
                    "mensagem" => "OS atualizada com sucesso"
                ]);
            }catch(Exception $error){
                return response()->json([

                    "retorno" => 2,
                    "mensagem" => "Ocorreu um erro na tentativa de atualizar OS"
                ]);
            }

        }


        private function uploadS3($arquivo, $occurrence_id)
        {
            $archivePath = "temp/";
            $fileName = md5(date("Y_m_d_h_i_s")) . "_" . rand() . "." . $arquivo->getClientOriginalExtension();
            $path = $archivePath . $fileName;
            $arquivo->move($archivePath, $fileName);
            $s3Client = Storage::disk('s3');
            $image_name = env("S3_PATH") . get_contractor_to_s3() . "images/occurrences/" . $occurrence_id . "/" . $fileName;


            if (\File::exists($path)) {
                $contents = \File::get($path);
                $s3Client->put($image_name, $contents);
                \File::delete($path);
                return $s3Client->url($image_name);
            }
        }

        private function gerarPdf($occurrence)
        {
            $url = str_replace('admin/occurrences/', '', request()->url());

            return PDF::loadFile(str_replace('//pdf', '/pdf', $url))->inline($occurrence->id . '.pdf');
        }

        private function uploadPdfS3($pdf, $occurrence_id, $pdfName)
        {
            $s3Client = Storage::disk('s3');
            $output_file_tmp = storage_path() . "/pdf/" . $pdf;
            $pdf_name = env("S3_PATH") . get_contractor_to_s3() . "images/occurrences/" . $occurrence_id . "/" . $pdfName . '.pdf';
            $s3Client->put($pdf_name, $output_file_tmp);
            return $s3Client->url($pdf_name);
        }

        public function uploadJson($occurrence)
        {
            $jsonFileURL = $occurrence->url;
            if (!$jsonFileURL) {
                return redirect()->back()->with('error', 'Arquivo não encontrado.');
            }
            $headers = get_headers($jsonFileURL, true);
            $contentLength = isset($headers['Content-Length']) ? intval($headers['Content-Length']) : 0;
            $jsonSizeKb = round($contentLength / 1024, 2);
            $tempFilePath = tempnam(sys_get_temp_dir(), 'json_');
            file_put_contents($tempFilePath, file_get_contents($jsonFileURL));
            $json = json_decode(\File::get($tempFilePath), true);

            if ($jsonSizeKb > 400) {
                try {
                    // Atualizar o campo JSON em um registro existente
                    $occurrence->json = $json;
                    unlink($tempFilePath);
                    $occurrence->save();
                    return redirect()->back()->with('message', 'Atualização efetuada com sucesso.');
                } catch (\Exception $exception) {
                    return redirect()->back()->with('error', 'Erro ao efetuar a atualização: ' . $exception->getMessage());
                }
            } else {
                try {
                    // Salvar o JSON em um novo registro
                    $occurrenceDynamo = new OccurrenceDynamo();
                    $occurrenceDynamo->occurrence_id = $occurrence->id;
                    $occurrenceDynamo->occurrence_uuid = $occurrence->uuid;
                    $occurrenceDynamo->contractor_id = $occurrence->contractor_id;
                    $occurrenceDynamo->json = $json;
                    unlink($tempFilePath);
                    $occurrenceDynamo->save();

                    return redirect()->back()->with('message', 'Envio efetuado com sucesso.');
                } catch (\Exception $exception) {
                    return redirect()->back()->with('error', 'Erro ao efetuar o upload: ' . $exception->getMessage());
                }
            }
        }

    }
