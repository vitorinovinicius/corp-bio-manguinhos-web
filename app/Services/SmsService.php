<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 29/07/2019
     * Time: 13:46
     */

    namespace App\Services;

    use App\Criteria\SmsSelectCriteria;
    use App\Repositories\GeneralSettingRepository;
    use App\Repositories\SmsRepository;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Storage;
    use App\Repositories\ContractorRepository;

    class SmsService
    {
        /**
         * @var ZenviaSmsService
         */
        private $zenviaSmsService;
        /**
         * @var SmsRepository
         */
        private $smsRepository;
        /**
         * @var GeneralSettingRepository
         */
        private $generalSettingRepository;

        /**
         * @var ContractorRepository
         */
        private $contractorRepository;

        /**
         * SmsService constructor.
         * @param ZenviaSmsService $zenviaSmsService
         * @param SmsRepository $smsRepository
         * @param GeneralSettingRepository $generalSettingRepository
         */
        public function __construct(ZenviaSmsService $zenviaSmsService, SmsRepository $smsRepository, GeneralSettingRepository $generalSettingRepository, ContractorRepository $contractorRepository)
        {
            $this->zenviaSmsService = $zenviaSmsService;
            $this->smsRepository = $smsRepository;
            $this->generalSettingRepository = $generalSettingRepository;
            $this->contractorRepository = $contractorRepository;
        }

        public function index($request)
        {
            $this->smsRepository->pushCriteria(new SmsSelectCriteria());
            $smses = $this->smsRepository->orderBy("id", "desc")->paginate(100);

            return view('sms.index', compact('smses'));
        }

        public function show($sms)
        {
            return view('sms.show', compact('sms'));
        }


        public function enviaSms($occurrence)
        {
            //Verifica se a empresaa está habilitada para envio de sms
            $contractor = $this->contractorRepository->find($occurrence->contractor_id);
            if ($contractor->send_sms == 1) {
                //Verifica se nas configurações permite enviar SMS
                $general_setting = $this->generalSettingRepository->find(1);
                if ($general_setting) {
                    if ($general_setting->zenvia_status == 1) {

                        $nome = explode(" ", optional($occurrence->occurrence_client)->name);
                        $tecnico = explode(" ", optional($occurrence->operator)->name);

                        if (env('APP_PRODUCAO', true)) {
                            $url = env('REDIRECT', 'http://cs6.co/trial/') . $occurrence->id;
                        } else {
                            $url = env('REDIRECT', 'http://cs6.co/trialh/') . $occurrence->id;
                        }


                        $data["occurrence_id"] = $occurrence->id;
                        $data["mensagem"] = $nome[0] . ", o técnico " . $tecnico[0] . " está a caminho. Acompanhe aqui: " . $url;
                        $data["count"] = strlen($data["mensagem"]);
                        $data["contractor_id"] = $occurrence->contractor_id;


                        //Verifica os números
                        if ($occurrence->occurrence_client->occurrence_client_phones) {
                            foreach ($occurrence->occurrence_client->occurrence_client_phones as $occurrence_client_phone) {

                                if ($this->validaCelular($occurrence_client_phone->phone)) {
                                    if (env('APP_PRODUCAO', true)) {
                                        $data["telefone"] = $this->validaCelular($occurrence_client_phone->phone);
                                    } else {
                                        $data["telefone"] = "5521986610238";
                                    }
                                    //envia SMS
                                    try {
                                        $retorno = $this->zenviaSmsService->enviaSms($data);

                                        if (isset($retorno['status']) && $retorno['status'] == 1) {
                                            $dados = array(
                                                'occurrence_client_id' => optional($occurrence->occurrence_client)->id,
                                                'occurrence_id' => $occurrence->id,
                                                'telefone' => $data["telefone"],
                                                'conteudo' => $data["mensagem"],
                                                'agendamento' => null,
                                                'data_envio' => Carbon::now(),
                                                'status' => $retorno['response']['status'],
                                                'status_detalhe' => $retorno['response']['status_detalhe'],
                                                'status_motivo' => $retorno['response']['status_motivo'],
                                                'contractor_id' => $data["contractor_id"],
                                            );
                                            $this->smsRepository->create($dados);

                                            if ($retorno['response']['status'] == '00') {
                                                $occurrence->status_sms = 1; // Enviado com sucesso
                                                $occurrence->save();
                                                //                            return array('status' => 1, 'message' => "SMS enviado com sucesso");
                                            } else {
                                                $occurrence->status_sms = 2; // Erro ao enviar SMS
                                                $occurrence->save();
                                                //                            return array('status' => 2, 'message' => "Erro ao enviar o SMS: " . $retorno->getDetailDescription());
                                            }
                                        } else {
                                            //registra insformações
                                            $dados = array(
                                                'occurrence_client_id' => optional($occurrence->occurrence_client)->id,
                                                'occurrence_id' => $occurrence->id,
                                                'telefone' => null,
                                                'conteudo' => $data["mensagem"],
                                                'agendamento' => null,
                                                'data_envio' => null,
                                                'status' => 2,
                                                'status_detalhe' => $retorno['message'],
                                                'status_motivo' => null,
                                                'contractor_id' => $data["contractor_id"],
                                            );
                                            $this->smsRepository->create($dados);
                                            $occurrence->status_sms = 2; // Erro ao enviar SMS
                                            $occurrence->save();
                                        }
                                        break;
                                    } catch (\Exception $e) {
                                        //registra insformações
                                        $dados = array(
                                            'occurrence_client_id' => optional($occurrence->occurrence_client)->id,
                                            'occurrence_id' => $occurrence->id,
                                            'telefone' => null,
                                            'conteudo' => $data["mensagem"],
                                            'agendamento' => null,
                                            'data_envio' => null,
                                            'status' => 2,
                                            'status_detalhe' => $e->getMessage(),
                                            'status_motivo' => null,
                                            'contractor_id' => $data["contractor_id"],
                                        );
                                        $this->smsRepository->create($dados);
                                        $occurrence->status_sms = 2; // Erro ao enviar SMS
                                        $occurrence->save();
                                    }
                                } else {
                                    Storage::disk('public')->prepend('log/sms.txt', "CELULAR INVALIDO");
                                }
                            }
                        } else {
                            //Não tem telefone associado
                            $occurrence->status_sms = 3;
                            $occurrence->save();
                            //            return array('status' => 2, 'message' => "Sem telefone associado");
                        }
                        //        return array('status' => 2, 'message' => "Error.");
                    } else {
                        Storage::disk('public')->prepend('log/sms.txt', "Envio não permitido por configuração");
                        //            return array('status' => 2, 'message' => "Envio não permitido por configuração.");
                    }
                }
            } else {
                Storage::disk('public')->prepend('log/sms.txt', "Envio não permitido. Empreiteira não configurada para envio de SMS");
//                return array(
//                    'status' => 2,
//                    'message' => "Envio não permitido. Empreiteira não configurada para envio de SMS."
//                );
            }
        }

        private function validaCelular($telefone)
        {
            if (empty($telefone)) {
                return false;
            }

            $telefone = trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));

            //        $regexTelefone = "^[0-9]{11}$";

            $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular com ddd
            $regexCelSemDdd = '/[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular sem ddd

            if (preg_match($regexCel, $telefone)) {
                if (strlen($telefone) == 10) {
                    return "55" . substr_replace($telefone, '9', 2, 0);
                } else if (strlen($telefone) == 11) {
                    return "55" . $telefone;
                } else {
                    return false;
                }
            } else if (preg_match($regexCelSemDdd, $telefone)) {
                if (strlen($telefone) == 8) {
                    return "5521" . substr_replace($telefone, '9', 0, 0);
                } else if (strlen($telefone) == 9) {
                    return "5521" . $telefone;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function recebeStatus($request)
        {
            $data = $request->all();
            Storage::disk('public')->prepend('log/log_sms.txt', json_encode($data));

            $occurrence_id = $data["id"];
            $status_detalhe = $data["status"];

            try {

                $sms = $this->smsRepository->findWhere(["occurrence_id" => $occurrence_id])->last();

                $this->smsRepository->update(["status_detalhe" => $status_detalhe], $sms->id);
            } catch (\Exception $e) {
                Storage::disk('public')->prepend('log/log_sms.txt', $e->getMessage());
            }
        }

    }
