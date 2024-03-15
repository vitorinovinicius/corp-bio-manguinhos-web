<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * @var ContractorService
     */
    private $contractorService;
    /**
     * @var OperatorService
     */
    private $operatorService;

    /**
     * DashboardService constructor.
     * @param ContractorService $contractorService
     * @param OperatorService $operatorService
     */
    public function __construct(ContractorService $contractorService, OperatorService $operatorService)
    {

        $this->contractorService = $contractorService;
        $this->operatorService = $operatorService;
    }

    public function dashboard_nts()
    {
        $contractors = $this->contractorService->listContractors();

        $operators = $this->operatorService->getAllOperators();

        return [
          "contractors" => $contractors,
          "operators" => $operators,
        ];
    }

    public function monitoring_gastos_materiais()
    {
        $contractors = $this->contractorService->listContractors();

        $operators = $this->operatorService->getAllOperators();

        return [
          "contractors" => $contractors,
          "operators" => $operators,
        ];
    }

    public function dashboard_ajax(\Illuminate\Http\Request $request)
    {
        $sqlWhereContractor = $this->sqlWhereContractor($request);

        $schedules_all = DB::select("SELECT COUNT(o.id) as qtd FROM occurrences o
                                                  WHERE o.status IS NOT NULL
                                          $sqlWhereContractor");

        $schedules_realized = DB::select("SELECT COUNT(o.id) as qtd FROM occurrences o
                                                    WHERE o.status = 2
                                                    $sqlWhereContractor");
        $schedules_pending = DB::select("SELECT COUNT(o.id) as qtd FROM occurrences o
                                                   WHERE o.status = 1
                                                   AND o.operator_id IS NOT NULL
                                                   $sqlWhereContractor");
        $schedules_unsolved = DB::select("SELECT COUNT(o.id) as qtd FROM occurrences o
                                                    WHERE o.status = 3
                                                    $sqlWhereContractor
                                                    ");
        $schedules_inprogress = DB::select("SELECT COUNT(o.id) as qtd FROM occurrences o
                                                    LEFT JOIN moves on (o.id = moves.occurrence_id)
                                                    WHERE o.status = 1 and moves.move_type_id = 5
                                                    $sqlWhereContractor
                                                    ");
        $schedules_unassigned = DB::select("SELECT COUNT(o.id) as qtd FROM occurrences o
                                                   WHERE o.status = 1
                                                   AND o.operator_id IS NULL
                                                   $sqlWhereContractor
                                                   ");



        $schedules_all = $schedules_all[0]->qtd;
        $schedules_realized = $schedules_realized[0]->qtd;
        $schedules_pending = $schedules_pending[0]->qtd;
        $schedules_unsolved = $schedules_unsolved[0]->qtd;
        $schedules_inprogress = $schedules_inprogress[0]->qtd;
        $schedules_unassigned = $schedules_unassigned[0]->qtd;
        $total_atribuidos = $schedules_realized + $schedules_pending + $schedules_unsolved;

        return array(
            "schedules_all" => [
                "total" => $schedules_all,
                "progress" => ($schedules_all > 0) ? number_format((float)(($schedules_realized + $schedules_unsolved) / $schedules_all) * 100, 2, '.', '') : "0",
                "percent" => ($schedules_all > 0) ? number_format((float)(($schedules_realized + $schedules_unsolved) / $schedules_all) * 100, 2, '.', '') : "0"
            ],
            "schedules_realized" => [
                "total" => $schedules_realized,
                "progress" => ($schedules_all > 0) ? number_format((float)($schedules_realized / $schedules_all) * 100, 2, '.', '') : "0",
                "percent" => ($schedules_all > 0) ? number_format((float)($schedules_realized / $schedules_all) * 100, 2, '.', '') : "0"
            ],
            "schedules_pending" => [
                "total" => $schedules_pending,
                "progress" => ($schedules_all > 0) ? number_format((float)($schedules_pending / $schedules_all) * 100, 2, '.', '') : "0",
                "percent" => ($schedules_all > 0) ? number_format((float)($schedules_pending / $schedules_all) * 100, 2, '.', '') : "0"
            ],
            "schedules_unsolved" => [
                "total" => $schedules_unsolved,
                "progress" => ($schedules_all > 0) ? number_format((float)($schedules_unsolved / $schedules_all) * 100, 2, '.', '') : "0",
                "percent" => ($schedules_all > 0) ? number_format((float)($schedules_unsolved / $schedules_all) * 100, 2, '.', '') : "0"
            ],
            "schedules_unassigned" => [
                "total" => $schedules_unassigned,
                "progress" => ($schedules_all > 0) ? number_format((float)($schedules_unassigned / $schedules_all) * 100, 2, '.', '') : "0",
                "percent" => ($schedules_all > 0) ? number_format((float)($schedules_unassigned / $schedules_all) * 100, 2, '.', '') : "0"
            ],
            "schedules_inprogress" => [
                "total" => $schedules_inprogress,
                "progress" => ($schedules_all > 0) ? number_format((float)($schedules_inprogress / $schedules_all) * 100, 2, '.', '') : "0",
                "percent" => ($schedules_all > 0) ? number_format((float)($schedules_inprogress / $schedules_all) * 100, 2, '.', '') : "0"
            ],
            "schedules_atribuidos" => [
                "total" => $total_atribuidos,
                "progress" => ($schedules_all > 0) ? number_format((float)($total_atribuidos / $schedules_all) * 100, 2, '.', '') : "0",
                "percent" => ($schedules_all > 0) ? number_format((float)($total_atribuidos / $schedules_all) * 100, 2, '.', '') : "0"
            ],
        );
    }

    public function dashboard_tikets_ajax($request){

        $created_at = $request->input('scheduled_date');

        $sqlWhere="";

        if(\Defender::hasRole('cliente')){
            $user_id  = \Auth::user()->id;
            $sqlWhere = " AND user_id = $user_id" ;
        }


        if ($created_at) {
            $explodData = explode("-", $created_at);
            $explodDataIni = explode("/", trim($explodData[0]));
            $explodDataFim = explode("/", trim($explodData[1]));


            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

            if ($dataIni != "" && $dataFim != "") {
                $sqlWhere .= " AND DATE(`created_at`) BETWEEN '$dataIni' AND '$dataFim' ";
            } else {
                $sqlWhere .= " AND DATE(`created_at`) = DATE(CURDATE())  ";
            }
        } else {
            $sqlWhere .= " AND DATE(`created_at`) = DATE(CURDATE())  ";
        }


        //SELECTS

        $tikets_all = DB::select("SELECT COUNT(o.id) as qtd FROM tickets o
                                                  WHERE o.status IS NOT NULL
                                          $sqlWhere");

        $tikets_realized = DB::select("SELECT COUNT(o.id) as qtd FROM tickets o
                                                    WHERE o.status = 3
                                                    $sqlWhere");

        $tikets_canceled = DB::select("SELECT COUNT(o.id) as qtd FROM tickets o
                                                   WHERE o.status = 2
                                                   $sqlWhere");

        $tikets_all = $tikets_all[0]->qtd;
        $tikets_realized = $tikets_realized[0]->qtd;
        $tikets_canceled = $tikets_canceled[0]->qtd;

        return array(
            "tikets_all" => [
                "total" => $tikets_all,
                "progress" => ($tikets_all > 0) ? number_format((float)(($tikets_realized + $tikets_canceled) / $tikets_all) * 100, 2, '.', '') : "0",
                "percent" => ($tikets_all > 0) ? number_format((float)(($tikets_realized + $tikets_canceled) / $tikets_all) * 100, 2, '.', '') : "0"
            ],
            "tikets_realized" => [
                "total" => $tikets_realized,
                "progress" => ($tikets_all > 0) ? number_format((float)($tikets_realized / $tikets_all) * 100, 2, '.', '') : "0",
                "percent" => ($tikets_all > 0) ? number_format((float)($tikets_realized / $tikets_all) * 100, 2, '.', '') : "0"
            ],
            "tikets_canceled" => [
                "total" => $tikets_canceled,
                "progress" => ($tikets_all > 0) ? number_format((float)($tikets_canceled / $tikets_all) * 100, 2, '.', '') : "0",
                "percent" => ($tikets_all > 0) ? number_format((float)($tikets_canceled / $tikets_all) * 100, 2, '.', '') : "0"
            ],
        );

    }
    private function sqlWhereContractor($request){

        $contractor_id  = $request->input('contractor_id');
        $scheduled_date = $request->input('scheduled_date');

        $sqlWhereContractor = "";


        if (\Auth::user()->contractor_id) {
            $sqlWhereContractor .= " AND o.contractor_id = " . \Auth::user()->contractor_id;
        } elseif ($contractor_id != "" && is_numeric($contractor_id)) {
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

}
