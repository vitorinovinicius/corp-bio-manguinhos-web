<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 27/09/2017
     * Time: 17:35
     */

    namespace App\Services;


    use App\Criteria\AlertsDocumentCriteria;
    use App\Criteria\AlertSelectCriteria;
    use App\Repositories\AlertRepository;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Support\Facades\Auth;

    class AlertService
    {
        /**
         * @var AlertRepository
         */
        private $alertRepository;


        /**
         * AlertService constructor.
         * @param AlertRepository $alertRepository
         */
        public function __construct(AlertRepository $alertRepository)
        {
            $this->alertRepository = $alertRepository;
        }

        public function index()
        {        // Alertas relacionados aos documentos
            $alertsAll = $this->alertRepository->pushCriteria(new AlertSelectCriteria());

            $allAlert = $alertsAll->count();
            $totalOsAtraso = $alertsAll->skipCriteria()->getByCriteria(new AlertSelectCriteria())->where('type', 1)->count();
            $totalOsInterferencia = $alertsAll->skipCriteria()->getByCriteria(new AlertSelectCriteria())->where('type', 2)->count();
            $totalEquipamento = $alertsAll->skipCriteria()->getByCriteria(new AlertSelectCriteria())->where('type', 3)->count();
            $totalTempoMedio = $alertsAll->skipCriteria()->getByCriteria(new AlertSelectCriteria())->where('type', 4)->count();
            $totalHoraExtra = $alertsAll->skipCriteria()->getByCriteria(new AlertSelectCriteria())->where('type', 5)->count();

            $alerts = $this->alertRepository->skipCriteria(new AlertSelectCriteria())->pushCriteria(new AlertSelectCriteria())->paginate();

            return view("alerts.index", compact('alerts', 'allAlert', 'totalOsAtraso', 'totalOsInterferencia', 'totalEquipamento', 'totalTempoMedio', 'totalHoraExtra'));
        }


        /** Exibe alerta relacionado a um documento **/
        public function show_document($alert)
        {
            return view("alerts.show_document", compact('alert'));
        }

        /** Fecha alerta relacionado a um documento **/
        public function documents_close($request, $alert)
        {
            $data = $request->all();
            try {
                $data['treated_date'] = Carbon::now()->format('Y-m-d H:i:s');
                $data['treated_user_id'] = Auth::user()->id;

                $this->alertRepository->update($data, $alert->id);

            } catch (\Exception $e) {
                return redirect()->back()->with("error", "Falha ao fechar alerta!<br>" . $e->getMessage());
            }

            return redirect()->route("alerts.show_document", $alert->uuid)->with("message", "Alerta fechado com sucesso!");
        }


        public function store($request)
        {
            $data = $request->all();

            try {
                $dados = $this->alertRepository->create($data);
                $retorno = array(
                    "status" => 1,
                    "message" => "Item criado com sucesso",
                    "data" => $dados
                );
                return $retorno;
            } catch (Exception $e) {
                $retorno = array(
                    "status" => 2,
                    "message" => "Erro ao tentar editar o item",
                    "exception" => $e->getMessage()
                );
                return $retorno;
            }
        }

        public function show($alert)
        {
            return view('alerts.show', compact('alert'));
        }

        public function edit($alert)
        {
            return view('alerts.edit', compact('alert'));
        }

        public function update($request, $alert)
        {
            $data = $request->all();
            try {
                $this->alertRepository->update($data, $alert->id);
            } catch (Exception $e) {
                $retorno = array(
                    "status" => 2,
                    "message" => "Erro ao tentar editar o item",
                    "exception" => $e->getMessage()
                );
                return $retorno;
            }

            return redirect()->route('alerts.index')->with('message', 'Item atualizado com sucesso.');
        }

        public function delete($alert)
        {
            try {
                $alert->delete();
            } catch (Exception $e) {
                $retorno = array(
                    "status" => 2,
                    "message" => "Erro ao tentar remover o item",
                    "exception" => $e->getMessage()
                );
                return $retorno;
            }
            return redirect()->route('alerts.index')->with('message', 'Item deletado com sucesso.');
        }
    }
