<?php

    namespace App\Imports;

    use App\Repositories\LogImportErrorRepository;
    use App\Repositories\OccurrenceClientPhoneRepository;
    use App\Repositories\OccurrenceClientRepository;
    use App\Repositories\OccurrenceRepository;
    use App\Repositories\OccurrenceTypeRepository;
    use App\Repositories\UserRepository;
    use Carbon\Carbon;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Auth;
    use Maatwebsite\Excel\Concerns\ToCollection;

    class OccurrenceImport implements ToCollection
    {
        private $logImport;
        private $contractor_id;
        /**
         * @var UserRepository
         */
        private $userRepository;

        /**
         * OccurrenceImport constructor.
         * @param $logImport
         * @param $contractor_id
         * @param OccurrenceRepository $occurrenceRepository
         * @param LogImportErrorRepository $logImportErrorRepository
         * @param OccurrenceTypeRepository $occurrenceTypeRepository
         * @param OccurrenceClientRepository $occurrenceClientRepository
         * @param OccurrenceClientPhoneRepository $occurrenceClientPhoneRepository
         * @param UserRepository $userRepository
         */
        public function __construct($logImport, $contractor_id, OccurrenceRepository $occurrenceRepository, LogImportErrorRepository $logImportErrorRepository, OccurrenceTypeRepository $occurrenceTypeRepository, OccurrenceClientRepository $occurrenceClientRepository, OccurrenceClientPhoneRepository $occurrenceClientPhoneRepository, UserRepository $userRepository)
        {
            $this->logImport = $logImport;
            $this->contractor_id = $contractor_id;
            $this->logImportErrorRepository = $logImportErrorRepository;
            $this->occurrenceTypeRepository = $occurrenceTypeRepository;
            $this->occurrenceClientRepository = $occurrenceClientRepository;
            $this->occurrenceClientPhoneRepository = $occurrenceClientPhoneRepository;
            $this->occurrenceRepository = $occurrenceRepository;
            $this->userRepository = $userRepository;
        }


        /**
         * @param Collection $collections
         */
        public function collection(Collection $data)
        {

            /***
             * Montando HEADER
             */
            $arrayHeading = array(); //inicia um novo array para poder pegar só os títulos (heading)

            //Nesse foreach eu armazendo o Heading na vareável $arrayHeading
            foreach ($data[0] as $key => $value) {
                $arrayHeading[$key] = strtolower($this->tirarAcentos($value));
                if (empty($arrayHeading[$key])) {
                    $arrayHeading[$key] = "em_branco";
                }
            }

            unset($data[0]); //remove a primeira linha (Título)
            $data_final = array(); //inicia o array final, que vai conter os dados já com as chaves corretas
            foreach ($data as $key_ney => $data_new) {
                foreach ($data_new as $key => $value) {
                    if ($arrayHeading[$key] == "telefone") {
                        $data2['telefones'][] = trim($value);
                        continue;
                    }
                    $data2[$arrayHeading[$key]] = trim($value);
                }
                $data_final[] = $data2;
            }

            $lineNumber = 0;
            $qtdError = 0;
            $qtdOk = 0;

            foreach ($data_final as $key => $value) {

                $lineDetailClient = "Erro estrutural";

                if (!isset($value["numero_cliente"]) or empty(trim($value["numero_cliente"])) or empty(trim($value["data_agendamento"])) or empty(trim($value["endereco"]))) {
                    $errorMessage = "Um dos campos principais está vazio (Número Cliente, Data Agendamento ou Endereço) não pode ser encontrado.";
                    $this->registerLogImportError($this->logImport->id, $key, $lineDetailClient, $errorMessage);
                    $qtdError++;
                    continue;
                }

                /**
                 * Remove tracos da string e limpa para efetuar a busca
                 */
                $occurrenceType = $this->occurrenceTypeRepository->findWhere([
                    "name" => $value["nome_os"],
                    "contractor_id" => $this->contractor_id
                ])->last();

                if (!$occurrenceType) {
                    $errorMessage = "Não pode localizar o Tipo da OS (" . trim($value["nome_os"]) . ") no sistema. Por favor sinalize a equipe técnica ou revise a linha exportada para correção.";
                    $this->registerLogImportError($this->logImport->id, $key, $lineDetailClient, $errorMessage);
                    $qtdError++;
                    continue;

                }
                $value["occurrence_type_id"] = $occurrenceType->id;

                $arrayClient = [];

                if(isset($value["numero_cliente"]) && !empty($value["numero_cliente"])){
                    $arrayClient["client_number"] = $value["numero_cliente"];
                }

                if(isset($value["email"]) && !empty($value["email"])){
                    $arrayClient["email"] = $value["email"];
                }

                if(isset($value["nome_cliente"]) && !empty($value["nome_cliente"])){
                    $arrayClient["name"] = $value["nome_cliente"];
                }

                if(isset($value["cpf_cnpj"]) && !empty($value["cpf_cnpj"])){
                    $arrayClient["cpf_cnpj"] = $value["cpf_cnpj"];
                }

                if(isset($value["cep"]) && !empty($value["cep"])){
                    $arrayClient["cep"] = $value["cep"];
                }

                if(isset($value["endereco"]) && !empty($value["endereco"])){
                    $arrayClient["address"] = $value["endereco"];
                }

                if(isset($value["bairro"]) && !empty($value["bairro"])){
                    $arrayClient["district"] = $value["bairro"];
                }

                if(isset($value["municipio"]) && !empty($value["municipio"])){
                    $arrayClient["city"] = $value["municipio"];
                }

                $arrayClient["contractor_id"] = $this->contractor_id;

                //Verificar se o cliente já existe pelo código de cliente
                $client = $this->occurrenceClientRepository->findWhere([
                    "client_number" => intval(trim($value["numero_cliente"])),
                    "contractor_id" => $this->contractor_id
                ], ['id'])->first();

                /**
                 * Atualiza se existir se nao cria um novo
                 */
                if ($client) {
                    //Atualiza os dados
                    $this->occurrenceClientRepository->update($arrayClient, $client->id);
                } else {
                    //Cria um novo cliente
                    $client = $this->occurrenceClientRepository->create($arrayClient);
                }

                //Salva telefones
                foreach ($value["telefones"] as $key => $telefone) {
                    if ($telefone) {
                        $arrayTelefone["occurrence_client_id"] = $client->id;
                        $arrayTelefone["phone"] = trim($telefone);
                        $this->occurrenceClientPhoneRepository->updateOrCreate($arrayTelefone, $arrayTelefone);
                    }
                }

                if (isset($value["id_do_operador"]) && !empty(trim($value["id_do_operador"])) && is_numeric(trim($value["id_do_operador"]))) {
                    $operator = $this->userRepository->findWhere([
                        "id" => trim($value["id_do_operador"]),
                        "contractor_id" => $this->contractor_id
                    ])->first();
                    if ($operator) {
                        $value["operator_id"] = $operator->id;
                    }
                }
                //Formata Data
                if (isset($value["data_agendamento"]) && !empty($value["data_agendamento"])) {
                    $value["data_agendamento"] = (Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value["data_agendamento"]))->format('Y-m-d')) ;
                } else {
                    $value["data_agendamento"] = null;
                }

                // dd(gettype($value["hora_do_agendamento"]), $value["hora_do_agendamento"]);
                //Formata Hora
                if (isset($value["hora_do_agendamento"]) && !empty($value["hora_do_agendamento"])) {
                    if(strpos($value["hora_do_agendamento"], ':')){
                        $value["schedule_time"] = $value["hora_do_agendamento"];
                    }else{
                        $value["schedule_time"] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value["hora_do_agendamento"]))->format('H:i');
                    }
                } else {
                    $value["schedule_time"] = null;
                }


                if (isset($value["turno_atendimento"]) && !empty($value["turno_atendimento"])) {
                    $value["shift"] = turno_id(trim($value["turno_atendimento"]));
                }

                $value["status"] = 1; //Aberta
                $value["contractor_id"] = $this->contractor_id;
                $value["occurrence_client_id"] = $client->id;
                if (isset($value["prioridade"]) && !empty($value["prioridade"])) {
                    $value["priority"] = priority_id(trim($value["prioridade"]));
                } else {
                    $value["priority"] = 2; //Normal
                }
                $value["numero_cliente"] = trim($value["numero_cliente"]);
                $value["schedule_date"] = $value["data_agendamento"];
                $value["log_import_id"] = $this->logImport->id;
                $value["code_verification"] = rand(1000, 9999);
                $value["schedules_original"] = $value["data_agendamento"];
                $value["obs_empreiteira"] = $value["obs_os"];


                if (isset($value["numero_os"]) && !empty(trim($value["numero_os"]))) {

                    $occurrence = $this->occurrenceRepository->findWhere([
                        "numero_os" => trim($value["numero_os"]),
                        "contractor_id" => $this->contractor_id
                    ])->first();
                    if ($occurrence) {

                        if ($occurrence->status != 1) { //SE ELA FOI FECHADA
                            $lineDetailClient = "OS já existe";
                            $errorMessage = "Alerta! - A OS " . trim($value["numero_os"]) . " esta fechada e não pode ser modificada.";
                            $this->registerLogImportError($this->logImport->id, $key, $lineDetailClient, $errorMessage);
                            $qtdError++;
                        } else {
                            $dataAtualizada = $value;
                            $dataAtualizada["log_import_id"] = $this->logImport->id;
                            $dataAtualizada["order_flag"] = 0;
                            $this->occurrenceRepository->update($dataAtualizada, $occurrence->id);
                        }

                        $lineDetailClient = "OS atualizada";
                        $errorMessage = "Alerta! - A OS " . trim($value["numero_os"]) . " foi atualizada.";
                        $this->registerLogImportError($this->logImport->id, $key, $lineDetailClient, $errorMessage);
                        $qtdError++;
                        $qtdOk++;

                    } else {
                        //NAO EXISTE NENHUM CRIA
                        try {
                            $occurrence = $this->occurrenceRepository->create($value);
                            $qtdOk++;
                        } catch (\Exception $e) {
                            $errorMessage = "Erro ao cadastrar (" . trim($value["numero_os"]) . ") no sistema. Por favor sinalize a equipe técnica ou revise a linha exportada para correção.";
                            if (env('APP_DEBUG')) {
                                $errorMessage .= "<br>" . $e->getMessage();
                            }
                            $this->registerLogImportError($this->logImport->id, $key, $lineDetailClient, $errorMessage);
                            $qtdError++;
                            continue;
                        }
                    }
                } else {
                    //NAO EXISTE NENHUM CRIA
                    try {
                        $occurrence = $this->occurrenceRepository->create($value);
                        $qtdOk++;
                    } catch (\Exception $e) {
                        $errorMessage = "Erro ao cadastrar (" . trim($value["numero_os"]) . ") no sistema. Por favor sinalize a equipe técnica ou revise a linha exportada para correção.";
                        if (env('APP_DEBUG')) {
                            $errorMessage .= "<br>" . $e->getMessage();
                        }
                        $this->registerLogImportError($this->logImport->id, $key, $lineDetailClient, $errorMessage);
                        $qtdError++;
                        continue;
                    }
                }

                //Associa os forms a OS
                $occurrence->forms()->sync($occurrence->occurrence_type->forms);

                $lineNumber++;
            }


            //ADICIONANDO OS DADOS COMPLEMENTARES DA TABELA DE LOG IMPORT
            $this->logImport->qtd_error = $qtdError;
            $this->logImport->qtd_success = $qtdOk;
            $this->logImport->lines = $lineNumber;

            $this->logImport->save();
        }

        private function registerLogImportError($log_import_id, $lineNumber, $lineDetail, $errorMessage, $empreiteira = null)
        {
            $data = array(
                "log_import_id" => $log_import_id,
                "line_number" => $lineNumber,
                "line_detail" => $lineDetail,
                "error_message" => $errorMessage,
            );

            //        if (!Auth::user()->contractor_id || $empreiteira == null) {
            //            return redirect()->back()->exceptInput()->with('error', 'Usuário sem empreiteira definida.');
            //        }

            if (Auth::user()->contractor_id) {
                $data["contractor_id"] = Auth::user()->contractor_id;
            } elseif ($empreiteira != null) {
                $data["contractor_id"] = $empreiteira->id;
            }

            $this->logImportErrorRepository->create($data);
        }


        private function tirarAcentos($string)
        {
            $string = trim($string);
            return preg_replace(array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/",
                "/(ó|ò|õ|ô|ö)/",
                "/(Ó|Ò|Õ|Ô|Ö)/",
                "/(ú|ù|û|ü)/",
                "/(Ú|Ù|Û|Ü)/",
                "/(ñ)/",
                "/(Ñ)/",
                "/(Ç|ç)/",
                "/( |\/)/",
                "/\./",
                "/(-)/",
                "/(__)/",
                "/(º)/",
                "/(0|1|2|3|4|5|6|7|8|9)/"
            ), explode(" ", "a a e e i e o o u u n n c _  _   "), $string);
        }

        private function decode_title($string)
        {
            return trim(str_replace('  ', ' ', preg_replace('/[\\x13*$]/', '-', trim($string))));
        }

        private function formatDate($date)
        {
            if (isset($date) && !empty($date)) {
                if (is_object($date)) {
                    if (get_class($date) == "Carbon\Carbon") {
                        return $date->format('Y-m-d');
                    }
                } else {
                    $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');

                    return $date;
                }
            } else {
                return null;
            }

        }
    }
