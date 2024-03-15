<?php
/**
 * Created by PhpStorm.
 * User: CELTAPHP
 * Date: 07/11/2016
 * Time: 10:11
 */

namespace App\Http\Controllers;

use App\Criteria\OccurrenceSelectTodayCriteria;
use App\Criteria\TicketSelectCriteria;
use App\Http\Controllers\Controller;

use App\Models\Ticket;
use App\Repositories\OccurrenceRepository;
use App\Repositories\OccurrenceTypeRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;
use App\Services\ContractorService;
use App\Services\DashboardService;
use App\Services\OccurrenceTypeService;
use App\Services\OperatorService;
use Artesaos\Defender\Facades\Defender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Services\OccurrenceService;
use Carbon\Carbon;

class AdminController extends Controller
{
    private $operatorService;
    private $occurrenceTypeService;
    private $occurrenceRepository;
    private $occurrenceTypeRepository;
    private $contractorService;
    private $userRepository;
    private $dashboardService;
    private $occurrenceService;
    /**
     * @var TicketRepository
     */
    private $ticketRepository;


    public function __construct(
        OperatorService $operatorService,
        OccurrenceTypeService $occurrenceTypeService,
        OccurrenceTypeRepository $occurrenceTypeRepository,
        ContractorService $contractorService,
        OccurrenceRepository $occurrenceRepository,
        UserRepository $userRepository,
        DashboardService $dashboardService,
        OccurrenceService $occurrenceService,
        TicketRepository $ticketRepository
    )
    {
        $this->operatorService = $operatorService;
        $this->occurrenceTypeService = $occurrenceTypeService;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
        $this->occurrenceRepository = $occurrenceRepository;
        $this->contractorService = $contractorService;
        $this->userRepository = $userRepository;
        $this->dashboardService = $dashboardService;
        $this->occurrenceService = $occurrenceService;
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        return view('admin.index');
    }

    public function monitoring()
    {

        $contractors = $this->contractorService->listContractors();

        $operators = $this->operatorService->getAllOperators();


        if (
            Defender::hasPermission('admin.dashboard') ||
            Defender::hasPermission('admin.index') ||
            Defender::hasPermission('admin.monitoring')
        ) {
            if (Route::is("admin.monitoring") || Route::is("admin.index")) {
                return view('dashboards.monitoring',compact('operators','contractors'));
            } elseif (Route::is("admin.technical")) {
                return view('dashboards.technical',compact('operators','contractors'));
            }
        } else {
            return view('admin.blank');
        }
    }

    public function dashboard(Request $request)
    {

        $sqlWhereContractor = $this->sqlWhereContractor($request);

        $operators = $this->operatorService->getAllOperators();
        $contractors = $this->contractorService->listContractors();


        $sqlFechadas = "SELECT ot.name, count(*) total FROM occurrences o
                                              INNER JOIN occurrence_types ot ON ot.id = o.occurrence_type_id
                                              INNER JOIN users as u ON u.id = o.operator_id
                                            WHERE  o.status = 2 $sqlWhereContractor
                                            GROUP BY ot.name";

        $sqlPereformance = "SELECT u.id as name, count(*) total FROM occurrences o
                                              INNER JOIN occurrence_types ot ON ot.id = o.occurrence_type_id
                                              INNER JOIN users as u ON u.id = o.operator_id
                                            WHERE o.status = 2  $sqlWhereContractor
                                        GROUP BY u.id LIMIT 10;";

        $sqlNaoRealizado = "SELECT o.cancelamento_status_id as id, count(*) total FROM occurrences o
                                    WHERE o.status = 3
                                    $sqlWhereContractor
                                    GROUP BY o.cancelamento_status_id";

        $sqlPendente = "SELECT count(*) total FROM occurrences o
                                    WHERE o.status = 1
                                         AND o.operator_id IS NOT NULL
                                         $sqlWhereContractor";


        $sqlTotal = "SELECT ot.name,count(*) total FROM occurrences o
                                        INNER JOIN occurrence_types ot ON ot.id = o.occurrence_type_id
                                        WHERE  o.status IS NOT NULL  $sqlWhereContractor
                                        GROUP BY ot.name  LIMIT 10;";

        $graficoFechadas = DB::select($sqlFechadas);
        $graficoNaoRealizado = DB::select($sqlNaoRealizado);
        $graficoPerformance = DB::select($sqlPereformance);
        $graficoPendentes = DB::select($sqlPendente);
        $graficoTotal = DB::select($sqlTotal);

        $aValueTotal = "";
        $aLabelTotal = "";
        $totalGeral = 0;

        foreach ($graficoTotal as $grafico) {
            $aLabelTotal .= '"' . $grafico->name . '",';
            $aValueTotal .= '"' . $grafico->total . '",';

            $totalGeral = $totalGeral + $grafico->total;
        }

        $aValueFechadas = "";
        $aLabelFechadas = "";

        foreach ($graficoFechadas as $grafico) {
            $aLabelFechadas .= '"' . $grafico->name . '",';
            $aValueFechadas .= '"' . $grafico->total . '",';
        }


        $aValuePerformance = "";
        $aLabelPerformance = "";

        foreach ($graficoPerformance as $grafico) {
            $aLabelPerformance .= '"Técnico ' . $grafico->name . '",';
            $aValuePerformance .= '"' . $grafico->total . '",';
        }

        $aValueNRealizado = "";
        $aLabelNRealizado = "";
        $aReferenceNRealizado = "var aReferenceNRealizado = []; ";

        $i = 0;
        foreach ($graficoNaoRealizado as $grafico) {
            $aLabelNRealizado .= '"' . motivoNaoRealizadoNew($grafico->id) . '",';
            $aValueNRealizado .= '"' . $grafico->total . '",';
            $aReferenceNRealizado .= "aReferenceNRealizado[$i] = '" . $grafico->id . "'; \n";
            $i++;
        }

        $totalPendente = $graficoPendentes[0]->total;

        $aGraficos = [
            'aLabelTotal' => $aLabelTotal,
            'aValueTotal' => $aValueTotal,
            'aLabelFechadas' => $aLabelFechadas,
            'aValueFechadas' => $aValueFechadas,
            'aValuePerformance' => $aValuePerformance,
            'aLabelPerformance' => $aLabelPerformance,
            'aLabelNRealizado' => $aLabelNRealizado,
            'aValueNRealizado' => $aValueNRealizado,
            'aReferenceNRealizado' => $aReferenceNRealizado,
            'totalPendente' => $totalPendente,
            'totalGeral' => $totalGeral,
        ];

        return view('dashboards.dashboard', compact(
            'operators',
            'aGraficos',
            'contractors'));

    }

    //OK
    public function dashboard_ajax(Request $request)
    {
        return $this->dashboardService->dashboard_ajax($request);
    }

    public function dashboard_tikets_ajax(Request $request)
    {
        return $this->dashboardService->dashboard_tikets_ajax($request);
    }

    //OK
    public function technical_maps()
    {
        $operators = $this->operatorService->getAllOperators();
        $scheduled_date = request()->input('scheduled_date');

        $data = array();
        if ($operators->count() > 0){
            foreach ($operators as $key => $operator){
                if (!empty($operator->latitude) && !empty($operator->longitude)) {
                    $have_occurrence=0;
                    if (!empty($operator->occurrences)) {

                        if ($scheduled_date) {
                            $explodData = explode("-", $scheduled_date);
                            $explodDataIni = explode("/", trim($explodData[0]));
                            $explodDataFim = explode("/", trim($explodData[1]));


                            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                            if ($dataIni != "" && $dataFim != "") {
                                if($operator->occurrences->whereBetween('schedule_date', [$dataIni,$dataFim])->count()){
                                    $have_occurrence = 1;
                                }
                            } else {
                                if($operator->occurrences->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->count()){
                                    $have_occurrence = 1;
                                }
                            }
                        } else {
                            if($operator->occurrences->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->count()){
                                $have_occurrence = 1;
                            }
                        }
                    }

                    $data[] = array(
                        "lat" => floatval($operator->latitude),
                        "lng" => floatval($operator->longitude),
                        "nome" => "<p>" . $operator->id . " - <a href='/admin/operators/" . $operator->uuid ."' target='_blank'>" . $operator->name . "</a></p><p>Última conexão: " . (!empty($operator->last_connection) ? tempo_corrido($operator->last_connection) : " - ") ."</p><a class='btn btn-sm btn-primary white' role='button' href='/admin/occurrences/create/".$operator->uuid. "' id='create_os'>Criar OS para este técnico</a>",
                        "title" => $operator->id . " - " . $operator->name,
                        "have_occurrence" => $have_occurrence,
                        "icon" => optional($operator->contractor)->icon
                    );
                }
            }
        }

        return response()->json($data);
    }

    public function os_maps()
    {
        $this->occurrenceRepository->pushCriteria(new OccurrenceSelectTodayCriteria());
        $occurrences = $this->occurrenceRepository->all();
        $scheduled_date = request()->input('scheduled_date');

        $data = array();

        if ($occurrences->count() > 0){
            foreach ($occurrences as $key => $occurrence){
                if (!empty($occurrence->occurrence_client) && !empty($occurrence->occurrence_client)) {

                    if ($scheduled_date) {
                        $explodData = explode("-", $scheduled_date);
                        $explodDataIni = explode("/", trim($explodData[0]));
                        $explodDataFim = explode("/", trim($explodData[1]));


                        $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                        $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                        if ($dataIni != "" && $dataFim != "") {
                            if($occurrence->whereBetween('schedule_date', [$dataIni,$dataFim])->count()){
                                $have_occurrence = 1;
                            }
                        } else {
                            if($occurrence->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->count()){
                                $have_occurrence = 1;
                            }
                        }
                    } else {
                        if($occurrence->where('schedule_date', '=', \Illuminate\Support\Carbon::now()->format("Y-m-d"))->count()){
                            $have_occurrence = 1;
                        }
                    }
                }

                $data[] = array(
                    "address"=>"{$occurrence->occurrence_client->address} - {$occurrence->occurrence_client->number} - {$occurrence->occurrence_client->district} - {$occurrence->occurrence_client->city} - {$occurrence->occurrence_client->uf}",
                    "nome" => "{$occurrence->occurrence_client->name}",
                );
            }
        }

        $result = array_unique($data, SORT_REGULAR);
        $result = array_values($result);
        return response()->json($result);
    }

    public function table_list()
    {
        $operators = $this->operatorService->getAllOperators();
        $new_operators = array();

        foreach ($operators as $operator) {
            $result = dashboard_operator($operator);

            $new_operators[] = [
                "nome" => "<a href='/admin/operators/{$operator->uuid}' target='_blank'>".$operator->name."</a>",
                "equipe" =>  $operator->teams()->distinct()->get()->implode('name', ', '),
                "supervisor" =>  optional($operator->teams()->distinct()->first()->users()->wherePivot('is_supervisor', 1)->first())->name,
                "regiao" => $operator->regions->implode('name',', '),
                "empreiteira" => (!empty($operator->contractor_id)? $operator->contractor->name : "-"),
                "total_os" => $result["total_os"],
                "total_realizadas" => $result["total_realizadas"],
                "total_nao_realizadas" => $result["total_nao_realizadas"],
                "total_pendentes" => $result["total_pendente"],
                "media" => $result["media"] . "%",
                "eficiencia" => $result["eficiencia"] . "%",
                "last_connection" => $operator->last_connection ? tempo_corrido($operator->last_connection) : null,
                "cor_media" => tecnical_color($result["media"]),
                "cor_eficiencia" => tecnical_color($result["eficiencia"]),
                "cor_last_connection" => $operator->last_connection ? tempo_color($operator->last_connection) : "",
                "tempo_calc_last_connection" => tempo_calc($operator->last_connection),
                "alertas" => "<div class='d-flex'>
                    <span title='Os em atraso' class='badge-circle badge-circle-sm badge-circle-danger margin-lr-1'>{$result['total_os_atraso']}</span> ".
                    "<span title='Acima do tempo médio' class='badge-circle badge-circle-sm badge-circle-warning margin-lr-1'>{$result['total_os_tempo_medio']}</span> ".
                    "<span title='OS com interferencia' class='badge-circle badge-circle-sm badge-circle-secondary margin-lr-1'>{$result['total_os_interferencia']}</span> ".
                    "<span title='Horas extras' class='badge-circle badge-circle-sm badge-circle-success margin-lr-1'>{$result['total_horas_extas']}</span>
                 </div>",
            ];
        }
        return json_encode(array("data" => $new_operators));
    }

    public function table_tickets_list(Request $request)
    {
        $tickets = $this->ticketRepository->pushCriteria(new TicketSelectCriteria())->all();
        $newTikets=[];
        if($tickets){
            foreach ($tickets as $ticket) {
                $newTikets[] = [
                    'id' => "<a href='/admin/tickets/{$ticket->uuid}' target='_blank'>".$ticket->id."</a>",
                    'client' => $ticket->user->name,
                    'description' => $ticket->description,
                    'status' => Ticket::getStatus($ticket->status),
                    'justification' => $ticket->justification,
                    'created_at' => Carbon::parse($ticket->created_at)->format('d-m-Y'),                    
                    'OS' => ($ticket->occurrence) ? "<a href='/admin/occurrences/{$ticket->occurrence->uuid}' target='_blank'>".$ticket->occurrence->id."</a>" : "",                    
                ];
            }
        }
        return json_encode(array("data" => $newTikets));
    }


    private function sqlWhereContractor($request){

        $contractor_id  = $request->input('contractor_id');
        $scheduled_date = $request->input('scheduled_date');

        $sqlWhereContractor = "";

        if (\Auth::user()->contractor_id) {
            $sqlWhereContractor .= " AND o.contractor_id = " . \Auth::user()->contractor_id;
        }


        if ($contractor_id != "" && is_numeric($contractor_id)) {
            $sqlWhereContractor .= " AND o.contractor_id = $contractor_id";
        }
        if ($scheduled_date) {
            $explodData = explode("-", $scheduled_date);
            $explodDataIni = explode("/", trim($explodData[0]));
            $explodDataFim = explode("/", trim($explodData[1]));


            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

            if ($dataIni != "" && $dataFim != "") {
                $sqlWhereContractor .= " AND o.schedule_date BETWEEN '$dataIni' AND '$dataFim' ";
            } else {
                $sqlWhereContractor .= " AND o.schedule_date = CURDATE()  ";
            }
        } else {
            $sqlWhereContractor .= " AND o.schedule_date = CURDATE()  ";
        }

        $regionsUser = \Auth::user()->regions->implode('id', ',');
        $regiaoRole = \Auth::user()->hasRole('regiao');

        if ($regiaoRole) {
            $sqlWhereContractor .= " AND o.region_id IN($regionsUser)";
        }

        return $sqlWhereContractor;
    }

    public function dashboard_nts()
    {
        $retorno = $this->dashboardService->dashboard_nts();
        $contractors = $retorno["contractors"];
        $operators = $retorno["operators"];
        return view("dashboards.dashboard_nts",compact("contractors","operators"));
    }


}
