<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 25/04/2019
     * Time: 14:27
     */

    namespace App\Services\Api;


    use App\Models\OccurrenceClientPhone;
    use App\Models\OccurrenceDynamo;
    use App\Repositories\FormFieldRepository;
    use App\Repositories\OccurrenceClientRepository;
    use App\Repositories\OccurrenceDataClientRepository;
    use App\Repositories\OccurrenceFormFieldRepository;
    use App\Repositories\OccurrenceRepository;
    use App\Services\MailService;
    use App\Services\OccurrenceImageService;
    use File;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use Storage;
    use Auth;

    class StoreService
    {
        /**
         * @var OccurrenceRepository
         */
        private $occurrenceRepository;
        /**
         * @var OccurrenceImageService
         */
        private $occurrenceImageService;
        /**
         * @var FormFieldRepository
         */
        /**
         * @var OccurrenceFormFieldRepository
         */
        private $occurrenceFormFieldRepository;
        /**
         * @var OccurrenceClientRepository
         */
        private $occurrenceClientRepository;
        /**
         * @var OccurrenceDataClientRepository
         */
        private $occurrenceDataClientRepository;
        /**
         * @var MailService
         */
        private $mailService;

        /**
         * StoreService constructor.
         * @param OccurrenceRepository $occurrenceRepository
         * @param OccurrenceImageService $occurrenceImageService
         * @param OccurrenceFormFieldRepository $occurrenceFormFieldRepository
         * @param OccurrenceClientRepository $occurrenceClientRepository
         * @param OccurrenceDataClientRepository $occurrenceDataClientRepository
         * @param MailService $mailService
         */
        public function __construct(OccurrenceRepository $occurrenceRepository, OccurrenceImageService $occurrenceImageService, OccurrenceFormFieldRepository $occurrenceFormFieldRepository, OccurrenceClientRepository $occurrenceClientRepository, OccurrenceDataClientRepository $occurrenceDataClientRepository, MailService $mailService)
        {
            $this->occurrenceRepository = $occurrenceRepository;
            $this->occurrenceImageService = $occurrenceImageService;
            $this->occurrenceFormFieldRepository = $occurrenceFormFieldRepository;
            $this->occurrenceClientRepository = $occurrenceClientRepository;
            $this->occurrenceDataClientRepository = $occurrenceDataClientRepository;
            $this->mailService = $mailService;
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
         */
        public function storeOccurrence(Request $request)
        {
            $data = $request->all();

            if (!$request->input("occurrence_id")) {
                return response()->json(['message' => "Id não encontrada"], 500);
            }

            $user = Auth::user();

            $occurrenceId = $request->input("occurrence_id");
            $statusId = $request->input("status");

            $nameFile = "log_json_" . date("Ymd") . "_" . $data["occurrence_id"] . ".log";
            $nameFileErro = "erro_" . date("Ymd") . "_" . $data["occurrence_id"] . ".log";

            Storage::disk('public')->prepend('log/' . $nameFile, json_encode($data));
            $path = Storage::disk('public')->path('log/' . $nameFile);
            if (is_file($path)) {
                //sobe para S3
                $base = env('S3_PATH', 'centralmob/gns_staging/');
                $archive_name = $base . "archives/os/" . $data["occurrence_id"] . '.txt';
                $s3Client = Storage::disk('s3');
                $contents = File::get($path);
                $s3Client->put($archive_name, $contents);
                $data["url"] = $s3Client->url($archive_name);
                //deleta arquivo
                File::delete($path);
            }

            //Verifica se a OS já foi atendida
            $occurrence = $this->occurrenceRepository->findWhere(["id" => $occurrenceId])->first();

            if (!$occurrence) {
                Storage::disk('public')->prepend('log/' . $nameFileErro, "Os não encontrada");
                activity()->performedOn($occurrence)->causedBy($user)->inLog('Erro Occurrence Api')->log('Os não encontrada');

                return response()->json(['message' => "Os não encontrada"], 500);
            } else {
                if ($occurrence->status != 1) {
                    return response()->json(['message' => "Os já foi atualizada"], 200);
                }
            }


            //Salva os dados básicos no banco
            $data2 = array_map(function ($value) {
                return $value === "" ? NULL : $value;
            }, $data);


            //SEPARANDO E SALVANDO ITENS DOS DADOS BÁSICOS
            if (isset($data['cliente_acompanhante']) && !empty($data['cliente_acompanhante'])) {

                $retorno = $this->salva_data_client($occurrence, $data["cliente_acompanhante"]);

                if ($retorno["status"] == 2) {
                    Storage::disk('public')->prepend('log/' . $nameFileErro, "Data Client " . $retorno["error"]);

                    return response()->json(['message' => "Erro ao salvar os dados do Cliente Acompanhante. Erro: " . $retorno["error"]], 500);
                }

                $retorno_update_phones = $this->update_phones_client($occurrence, $data["cliente_acompanhante"]);

                if ($retorno_update_phones["status"] == 2) {
                    Storage::disk('public')->prepend('log/' . $nameFileErro, "Phones " . $retorno_update_phones["error"]);

                    return response()->json(['message' => "Erro ao salvar os dados do Cliente Acompanhante. Erro: " . $retorno["error"]], 500);
                }
            }

            $data2["check_in"] = Carbon::parse((isset($data2["check_in"])) ? $data2["check_in"] : null);
            $data2["check_out"] = Carbon::parse((isset($data2["check_out"])) ? $data2["check_out"] : null);
            $data2["check_in_lat"] = (isset($data2["check_in_lat"])) ? $data2["check_in_lat"] : null;
            $data2["check_in_long"] = (isset($data2["check_in_long"])) ? $data2["check_in_long"] : null;
            $data2["check_out_lat"] = (isset($data2["check_out_lat"])) ? $data2["check_out_lat"] : null;
            $data2["check_out_long"] = (isset($data2["check_out_long"])) ? $data2["check_out_long"] : null;
            $data2["status_schedule"] = (isset($data2["status_schedule"])) ? $data2["status_schedule"] : null;
            $data2["status_faturado"] = (isset($data2["status_faturado"])) ? $data2["status_faturado"] : null;

            //PARA INTERFERENCIAS

            if (isset($data2['interferences']) && !empty($data2['interferences'])) {
                $occurrence->interferences()->attach($data2['interferences'], ["contractor_id" => $user->contractor_id]);
            }

            //Salva assinatura
            if (isset($data2["assinatura"]) && !empty($data2["assinatura"]))
                $data2["assinatura"] = $this->occurrenceImageService->uploadUniqueImagemS3($data2["assinatura"], $data2["occurrence_id"], "assinatura");

            $data2["date_finish"] = Carbon::now();

            if ($statusId == 3) {
                $data2["cancelamento_status_id"] = (isset($data2["cancelamento_status_id"])) ? $data2["cancelamento_status_id"] : null;
                $data2["motivo_nao_realizacao"] = (isset($data2["obs_os"])) ? $data2["obs_os"] : null;
                unset($data2["obs_os"]);
                //Cancelado
                $data2["status"] = 3;
            } else {
                //Fechado
                $data2["status"] = 2;
            }

            try {
                $this->occurrenceRepository->update($data2, $occurrenceId);

                /** SALVA NO DYNAMO **/
                $occurrenceDynamo = new OccurrenceDynamo();
                $occurrenceDynamo->occurrence_id = $data["occurrence_id"];
                $occurrenceDynamo->occurrence_uuid = $this->occurrenceRepository->find($data["occurrence_id"], ["uuid"])->uuid;
                $occurrenceDynamo->contractor_id = $user->contractor_id;
                $occurrenceDynamo->json = $data;
                $occurrenceDynamo->save();

                activity()->performedOn($occurrence)->causedBy($user)->inLog('Update Occurrence Api')->log('Os finalizada');

                return response()->json(['message' => "Os atualizado com sucesso"]);

            } catch (\Exception $exception) {

                Storage::disk('public')->prepend('log/' . $nameFileErro, "Erro ao atualizar OS " . $exception->getMessage());

                return response()->json(['message' => "Erro ao atualizar OS"], 500);
            }

        }

        private function update_phones_client($occurrence, $cliente_acompanhante)
        {
            try {
                $cliente_acompanhante['occurrence_id'] = $occurrence->id;

                $client = $occurrence->occurrence_client;

                if ($client) {
                    if (isset($cliente_acompanhante['cliente_phones'])) {
                        $phones = explode(",", $cliente_acompanhante['cliente_phones']);

                        if (count($phones) > 0) {
                            foreach ($client->occurrence_client_phones as $phone) {
                                $phone->delete();
                            }

                            foreach ($phones as $phone) {
                                OccurrenceClientPhone::create([
                                    'occurrence_client_id' => $client->id,
                                    'phone' => $phone
                                ]);
                            }
                        }
                    }
                }

            } catch (\Exception $exception) {
                return array(
                    'status' => 2,
                    'error' => $exception->getMessage()
                );
            }

            return array('status' => 1);
        }

        private function salva_data_client($occurrence, $cliente_acompanhante)
        {
            try {
                $cliente_acompanhante['occurrence_id'] = $occurrence->id;

                //cliente_assinatura_tecnico
                if (isset($cliente_acompanhante["cliente_assinatura_tecnico"]) && !empty($cliente_acompanhante["cliente_assinatura_tecnico"]))
                    $cliente_acompanhante["cliente_assinatura_tecnico"] = $this->occurrenceImageService->uploadUniqueImagemS3($cliente_acompanhante["cliente_assinatura_tecnico"], $cliente_acompanhante["occurrence_id"], "Assinatura do técnico");

                $verifica_odc = $this->occurrenceDataClientRepository->findWhere(["occurrence_id" => $occurrence->id])->first();
                if ($verifica_odc) {
                    $this->occurrenceDataClientRepository->update($cliente_acompanhante, $verifica_odc->id);
                } else {
                    $this->occurrenceDataClientRepository->create($cliente_acompanhante);
                }

                //Atualiza cliente
                if ($cliente_acompanhante['cliente_tipo'] == 1) {
                    $occurrence_cliente["occurrence_id"] = $occurrence->id;

                    if(isset($cliente_acompanhante['cliente_email']) && !empty($cliente_acompanhante['cliente_email'])){
                        $occurrence_cliente['email'] = $cliente_acompanhante['cliente_email'];
                    }

                    if(isset($cliente_acompanhante['cpf_cnpj']) && !empty($cliente_acompanhante['cpf_cnpj'])){
                        $occurrence_cliente['cpf_cnpj'] = $cliente_acompanhante['cliente_cpf'];
                    }


                    $this->occurrenceClientRepository->update($occurrence_cliente, $occurrence->occurrence_client->id);
                }

            } catch (\Exception $exception) {
                return array(
                    'status' => 2,
                    'error' => $exception->getMessage()
                );
            }

            return array('status' => 1);
        }

    }
