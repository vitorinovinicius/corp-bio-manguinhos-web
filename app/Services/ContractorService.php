<?php
    /**
     * Created by PhpStorm.
     * User: CELTAPHP
     * Date: 21/12/2016
     * Time: 13:15
     */

    namespace App\Services;


    use App\Repositories\ContractorRepository;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\Storage;
    use App\Criteria\ContractorCriteria;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
    use App\Services\RoutingService;

    class ContractorService
    {
        private $contractorRepository;
        private $routingService;

        /**
         * ContractorService constructor.
         * @param ContractorRepository $contractorRepository
         */
        public function __construct(ContractorRepository $contractorRepository, RoutingService $routingService)
        {
            $this->contractorRepository = $contractorRepository;
            $this->routingService = $routingService;
        }

        public function listContractorsIndex()
        {

            return $this->contractorRepository->orderBy('name', 'asc')->paginate();
        }

        public function listContractors()
        {

            $this->contractorRepository->pushCriteria(new ContractorCriteria());
            $contractors = $this->contractorRepository->paginate();
            return $contractors;
        }

        public function listFilter($id)
        {
            return $this->contractorRepository->findWhere(["id" => $id])->first();
        }

        public function addNewContractor($request)
        {
            try {

                $data = $request->all();

                //Realizando a busca das coordenadas
                $coordinates = getCoordsAddressGMAPS($data['address']);

                if (isset($coordinates['lat']) && !empty($coordinates['lat']) && isset($coordinates['lng']) && !empty($coordinates['lng'])) {

                    $data['lat'] = $coordinates['lat'];
                    $data['lng'] = $coordinates['lng'];
                    $this->routingService->salveRouting(null, [['address' => $data['address']]], [$coordinates], 2);
                }

                if (isset($data['visibility'])) {
                    $data["visibility"] = 1;
                }


                $contractor = $this->contractorRepository->create($data);

                $iconeFile = $request->file('iconeFile');
                if ($iconeFile) {
                    $data["icon"] = $this->upload_imagens($iconeFile, $contractor->id);
                }

                $logo_cabecalho = $request->file('logo_cabecalho');
                if ($logo_cabecalho) {
                    $data["logo_cabecalho"] = $this->upload_imagens($logo_cabecalho, $contractor->id);
                }

                $this->contractorRepository->update($data, $contractor->id);


                if (isset($data['region_id'])) {
                    $contractor->regions()->attach($data['region_id']);
                }

                return redirect()->route('contractors.index')->with('message', 'Item criado com sucesso.');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors()->with("error", "Erro ao cadastrar a Empresa: " . $e->getMessage());
            }

        }

        public function editContractor($request, $contractor)
        {
            try {
                $data = $request->all();

                //VERIFICA SE HÁ ALTERAÇÃO NO ENDEREÇO E CHAMA FUNÇÃO PARA NOVAS COORDENADAS
                if ($contractor->address != $data['address']) {

                    $coordinates = getCoordsAddressGMAPS($data['address']);
                    if (isset($coordinates['lat']) && !empty($coordinates['lat']) && isset($coordinates['lng']) && !empty($coordinates['lng'])) {

                        $data['lat'] = $coordinates['lat'];
                        $data['lng'] = $coordinates['lng'];

                        $this->routingService->salveRouting(null, [['address' => $data['address']]], [$coordinates], 2);
                    }
                }

                if (!isset($data['send_mail'])) {
                    $data['send_mail'] = 0;
                }

                if (!isset($data['send_sms'])) {
                    $data['send_sms'] = 0;
                }

                $iconeFile = $request->input('iconeFile');
                if ($iconeFile) {
                    $data["icon"] = $this->upload_imagens($iconeFile, $contractor->id);
                }

                $logo_cabecalho = $request->input('logo_cabecalho');
                if ($logo_cabecalho) {
                    $data["logo_cabecalho"] = $this->upload_imagens($logo_cabecalho, $contractor->id, 'logo_cabecalho');
                }

                $this->contractorRepository->update($data, $contractor->id);

                if (isset($data['region_id'])) {
                    $contractor->regions()->sync($data['region_id']);
                }

                return redirect()->route('contractors.index')->with('message', 'Item atualizado com sucesso.');

            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors()->with("error", "Erro ao cadastrar a Empresa: " . $e->getMessage());
            }

        }

        public function deleteContractor($contractor)
        {
            $contractor->regions()->detach();
            $contractor->delete();
            return redirect()->route('contractors.index')->with('message', 'Equipe ' . $contractor->name . ' deletada com sucesso.');
        }

        public function showContractor($contractor)
        {

            return view('contractors.show', compact('contractor'));
        }

        private function upload_imagens($file, $contrator_id, $name = 'icone')
        {

            $archivePath = "contractor/" . $contrator_id . "/image/";
            $fileName = date("Y_m_d_H_i_s") . "_" . $name . "." . $file->getClientOriginalExtension();
            $path = $archivePath . $fileName;
            $file->move($archivePath, $fileName);
            $s3Client = Storage::disk('s3');
            $cert_name = env("S3_PATH") . get_contractor_to_s3() . "icone/" . $fileName;
            if (\File::exists($path)) {
                $contents = \File::get($path);
                $s3Client->put($cert_name, $contents);
                \File::delete($path);
                $url = $s3Client->url($cert_name);
            } else {
                $url = null;
            }

            return $url;
        }

        // private function salveRouting($aOccurrences, $steps)
        // {
        //      //INSERT TABELA DE ROTEIRIZACAO
        //      if (Auth::user()->contractor_id) {
        //         $data["contractor_id"] = Auth::user()->contractor_id;
        //     }
        //     $data['routing_date'] = Carbon::now()->format('Y-m-d H:m:s');
        //     $data['addresses'] = json_encode($aOccurrences);
        //     $data['routed_addresses'] = json_encode($steps);
        //     $data['type'] = 2;
        //     $this->routingRepository->create($data);
        // }


        public function adminShowContractor()
        {
            if (!Auth::user()->contractor_id) {
                return redirect()->route('admin.index')->with('error', 'Não foi encontrado empresa associado ao seu usuário');
            }

            $contractor = $this->contractorRepository->find(Auth::user()->contractor->id);

            return view('contractors.admin_show', compact('contractor'));


        }

        public function editAdmin()
        {
            if (!Auth::user()->contractor_id) {
                return redirect()->route('admin.index')->with('error', 'Não foi encontrado empresa associado ao seu usuário');
            }

            $contractor = $this->contractorRepository->find(Auth::user()->contractor->id);
            return view('contractors.admin_edit', compact('contractor'));
        }

        public function adminUpdate(\Illuminate\Http\Request $request)
        {
            if (!Auth::user()->contractor_id) {
                return redirect()->route('admin.index')->with('error', 'Não foi encontrado empresa associado ao seu usuário');
            }

            $contractor = $this->contractorRepository->find(Auth::user()->contractor->id);

            $data = $request->all();

            if (isset($data["send_mail"]) && $data["send_mail"] == 1) {

                if ((!isset($data["mail_driver"]) || empty($data["mail_driver"])) or (!isset($data["mail_host"]) || empty($data["mail_host"])) or (!isset($data["mail_port"]) || empty($data["mail_port"])) or (!isset($data["mail_from_address"]) || empty($data["mail_from_address"])) or (!isset($data["mail_from_name"]) || empty($data["mail_from_name"]))) {

                    return redirect()->back()->withInput()->with("error", 'Alguma configuração de envio de email não foi enviada');
                }
            }


            //Se as senhas forem diferentes, dá erro
            if ((isset($data["mail_password"]) && !empty($data["mail_password"])) || (isset($data["re_mail_password"]) && !empty($data["re_mail_password"]))) {
                if ($data["mail_password"] != $data["re_mail_password"]) {
                    return redirect()->back()->withInput()->with("error", 'A senha e confirmação de senha não coincidem');
                }
            }

            //Se não está sendo alterada ou é a mesma senha, não faz mudança
            if (($contractor->mail_password && empty($request->input('mail_password'))) || ($request->input('mail_password') == $contractor->mail_password)) {
                unset($data["mail_password"]);
            }

            //VERIFICA SE HÁ ALTERAÇÃO NO ENDEREÇO E CHAMA FUNÇÃO PARA NOVAS COORDENADAS
            if ($contractor->address != $data['address']) {

                $coordinates = getCoordsAddressGMAPS($data['address']);
                $data['lat'] = $coordinates['lat'];
                $data['lng'] = $coordinates['lng'];

                $this->routingService->salveRouting(null, [['address' => $data['address']]], [$coordinates], 2);
            }

            $iconeFile = $request->file('iconeFile');
            if ($iconeFile) {
                $data["icon"] = $this->upload_imagens($iconeFile, $contractor->id);
            }

            $logo_cabecalho = $request->file('logo_cabecalho');
            if ($logo_cabecalho) {
                $data["logo_cabecalho"] = $this->upload_imagens($logo_cabecalho, $contractor->id, 'logo_cabecalho');
            }

            $this->contractorRepository->update($data, $contractor->id);

            return redirect()->route('contractors.admin.show')->with("message", "Alteração realizada com sucesso");

        }

    }
