<?php
/**
 * Created by PhpStorm.
 * User: Guilherme
 * Date: 08/11/2016
 * Time: 14:48
 */

namespace App\Services;

use App\Criteria\Api\InterferenceCriteria;
use App\Criteria\InterferenceClientCriteria;
use App\Criteria\InterferenceSelectCriteria;
use App\Criteria\OccurrenceCityCriteria;
use App\Criteria\OccurrenceInterferenceCriteria;
use App\Criteria\OperatorSelectCriteria;
use App\Repositories\ContractorRepository;
use App\Repositories\InterferenceRepository;
use App\Repositories\OccurrenceClientRepository;
use App\Repositories\OccurrenceRepository;
use App\Repositories\OccurrenceTypeRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class InterferenceService
{

    private $interferenceRepository;
    /**
     * @var ContractorRepository
     */
    private $contractorRepository;
    /**
     * @var OccurrenceRepository
     */
    private $occurrenceRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OccurrenceClientRepository
     */
    private $occurrenceClientRepository;
    /**
     * @var OccurrenceTypeRepository
     */
    private $occurrenceTypeRepository;

    /**
     * InterferenceService constructor.
     * @param InterferenceRepository $interferenceRepository
     * @param ContractorRepository $contractorRepository
     * @param OccurrenceRepository $occurrenceRepository
     * @param UserRepository $userRepository
     * @param OccurrenceClientRepository $occurrenceClientRepository
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     */
    public function __construct(InterferenceRepository $interferenceRepository, ContractorRepository $contractorRepository, OccurrenceRepository  $occurrenceRepository, UserRepository  $userRepository, OccurrenceClientRepository  $occurrenceClientRepository, OccurrenceTypeRepository  $occurrenceTypeRepository)
    {
        $this->interferenceRepository = $interferenceRepository;
        $this->contractorRepository = $contractorRepository;
        $this->occurrenceRepository = $occurrenceRepository;
        $this->userRepository = $userRepository;
        $this->occurrenceClientRepository = $occurrenceClientRepository;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
    }

    public function addNewInterference($interferenceRequest)
    {
        if (!\Auth::user()->contractor_id) {
            return redirect()->route('interferences.index')->with('error', "Apenas empresas têm acesso a criar o item.");
        }

        $data = $interferenceRequest->all();

        try{
            $this->interferenceRepository->create($data);
        }
        catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }


        return redirect()->route('interferences.index')->with('message', 'Item criado com sucesso.');

    }

    public function editInterference($request, $interference)
    {

        $data = $request->all();

        $this->interferenceRepository->update($data, $interference->id);
    }

    public function listInterferences()
    {
        return $this->interferenceRepository->pushCriteria(new InterferenceSelectCriteria())->paginate();
    }

    public function deleteInterference($interference)
    {
        $interference->delete();
        return redirect()->route('interferences.index')->with('message', 'Interferência '.$interference->name.' deletada com sucesso.');
    }

    public function showInterference($interference){

        return view('interferences.show', compact('interference'));
    }

    public function getInterferences()
    {
        $this->interferenceRepository->pushCriteria(new InterferenceCriteria());

        $interferences = $this->interferenceRepository->all();
        return $interferences;
    }

        public function dashboard_ajax($request)
        {

            $sqlWhereContractor = $this->sqlWhereContractor($request);

            $interferences_all = DB::select("
                SELECT COUNT(occurrence_interference.id) as qtd FROM occurrence_interference
                    JOIN occurrences on occurrence_interference.occurrence_id = occurrences.id
                    WHERE occurrence_interference.id IS NOT NULL
                    $sqlWhereContractor
                    ");
            $interferences_all = $interferences_all[0]->qtd;


            $this->interferenceRepository->pushCriteria(new InterferenceSelectCriteria());
            $interferences = $this->interferenceRepository->all();

            $data_final = [];
            foreach ($interferences as $key => $interference) {
                //            dd($interference);

                $occurrences = $interference->occurrences();

                $contractor_id = Request::get('contractor_id');
                if (\Auth::user()->contractor_id) {
                    $occurrences->where('occurrences.contractor_id', '=', \Auth::user()->contractor_id);
                } elseif (isset($contractor_id) && !empty($contractor_id)) {
                    $occurrences->where('occurrences.contractor_id', '=', $contractor_id);
                }

                $date_range = Request::get('scheduled_date');
                if (isset($date_range) && !empty($date_range)) {
                    $date_range = format_range_to_database($date_range);
                    $occurrences->whereBetween('occurrences.schedule_date', [
                        $date_range[0],
                        $date_range[1]
                    ]);
                } else {
                    $occurrences->where('occurrences.schedule_date', Carbon::today());

                }

                $data_final['interferences'][$key]['id'] = $interference->id;
                $data_final['interferences'][$key]['description'] = $interference->description;
                $data_final['interferences'][$key]['total'] = $occurrences->count();
                $data_final['interferences'][$key]['percent'] = ($interferences_all > 0) ? number_format((float)($occurrences->count() / $interferences_all) * 100, 2, '.', '') : "0";

            }

            return response()->json([
                'data' => $data_final,
                'total' => $interferences_all
            ], '200');
        }

        public function relatorio_show($interference)
        {
            $this->occurrenceRepository->pushCriteria(new OccurrenceInterferenceCriteria($interference));
            $occurrences = $this->occurrenceRepository->paginate();
            $occurrences_all = $occurrences->total();

            $this->userRepository->pushCriteria(new OperatorSelectCriteria());
            $operators = $this->userRepository->all();
            //        $operators = $this->userRepository->findWhere(["status" => 1]);

            $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->all();

            $occurrence_types = $this->occurrenceTypeRepository->all();
            $contractors = $this->contractorRepository->all();

            return view('interferences.occurrences', compact('interference', 'occurrences', 'occurrence_types', 'operators', 'occurrence_clients', 'occurrences_all', 'contractors'));

        }

        public function dashboard()
        {
            $interferences_all = $this->interferenceRepository->pushCriteria(new InterferenceSelectCriteria())->all();


            $contractors = $this->contractorRepository->all();

            return view('interferences.dashboard', compact('interferences_all', 'contractors'));
        }

        public function dashboardInterferences()
        {
            $interferences_all = $this->interferenceRepository->pushCriteria(new InterferenceSelectCriteria())->all();

            $contractors = $this->contractorRepository->all();

            return view('interferences.dashboard_interferences', compact('interferences_all', 'contractors'));
        }

        private function sqlWhereContractor($request)
        {

            $contractor_id = $request->input('contractor_id');
            $scheduled_date = $request->input('scheduled_date');

            $sqlWhereContractor = "";

            if (\Auth::user()->contractor_id) {
                $sqlWhereContractor .= " AND occurrences.contractor_id = " . \Auth::user()->contractor_id;
            }


            if ($contractor_id != "" && is_numeric($contractor_id)) {
                $sqlWhereContractor .= " AND occurrences.contractor_id = $contractor_id";
            }
            if ($scheduled_date) {
                $explodData = explode("-", $scheduled_date);
                $explodDataIni = explode("/", trim($explodData[0]));
                $explodDataFim = explode("/", trim($explodData[1]));


                $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                if ($dataIni != "" && $dataFim != "") {
                    $sqlWhereContractor .= " AND occurrences.schedule_date BETWEEN '$dataIni' AND '$dataFim' ";
                } else {
                    $sqlWhereContractor .= " AND occurrences.schedule_date = CURDATE()  ";
                }
            } else {
                $sqlWhereContractor .= " AND occurrences.schedule_date = CURDATE()  ";
            }

            //todo: Naturgy CRC
            $regionsUser = \Auth::user()->regions->implode('id', ',');
            //            $regionsUser = \Auth::user()->regions->pluck('id');
            $regiaoRole = \Auth::user()->hasRole('regiao');

            if (($regiaoRole || $regionsUser) && !\Auth::user()->isSuperUser()) {
                $sqlWhereContractor .= " AND occurrences.company IN($regionsUser)";
            }


            return $sqlWhereContractor;
        }

        public function clients()
        {

            $this->occurrenceClientRepository->pushCriteria(new InterferenceClientCriteria());
            $occurrence_clients = $this->occurrenceClientRepository->paginate();

            $interferences = $this->interferenceRepository->all();

            return view('interferences.clients', compact('occurrence_clients', 'interferences'));

        }

    }
