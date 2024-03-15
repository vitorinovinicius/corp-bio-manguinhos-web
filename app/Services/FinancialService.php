<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16/11/2017
 * Time: 15:40
 */

namespace App\Services;


use App\Criteria\FinancialListCriteria;
use App\Criteria\OccurrenceFinancialDashboardCriteria;
use App\Repositories\ContractorRepository;
use App\Repositories\FinancialCommunicationRepository;
use App\Repositories\FinancialRepository;
use App\Repositories\OccurrenceRepository;
use App\Services\UploadService;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class FinancialService
{
    /**
     * @var FinancialRepository
     */
    private $financialRepository;
    /**
     * @var OccurrenceRepository
     */
    private $occurrenceRepository;
    /**
     * @var FinancialCommunicationRepository
     */
    private $financialCommunicationRepository;
    /**
     * @var ContractorRepository
     */
    private $contractorRepository;

    private $uploadService;

    /**
     * FinancialService constructor.
     * @param FinancialRepository $financialRepository
     * @param OccurrenceRepository $occurrenceRepository
     * @param FinancialCommunicationRepository $financialCommunicationRepository
     * @param ContractorRepository $contractorRepository
     */
    public function __construct(
        FinancialRepository $financialRepository,
        OccurrenceRepository $occurrenceRepository,
        FinancialCommunicationRepository $financialCommunicationRepository,
        ContractorRepository $contractorRepository,
        UploadService $uploadService
    )
    {
        $this->financialRepository = $financialRepository;
        $this->occurrenceRepository = $occurrenceRepository;
        $this->financialCommunicationRepository = $financialCommunicationRepository;
        $this->contractorRepository = $contractorRepository;
        $this->uploadService = $uploadService;;
    }

    public function index()
    {
        $this->financialRepository->pushCriteria(new FinancialListCriteria());
        $financials = $this->financialRepository->paginate();

        return view('financials.index', compact('financials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $occurrence
     * @return Response
     */
    public function create($occurrence)
    {
        return view('financials.create', compact('occurrence'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($occurrence, $request)
    {
        $data = $request->all();
        $data["user_id"] = \Auth::user()->id;
        $data["occurrence_id"] = $occurrence->id;      

        try {
            $financial = $this->financialRepository->create($data);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar salvar o item. <br>Erro: '.$e->getMessage());
        }

        /*
            0 - Pendente
            1 - Aprovado
            2 - Reprovado
            3 - Solicitado ajuste
            4 - Ajuste feito pela ECC
        */
        if($data["status"] == 1){
            $data["data_approved"] = Carbon::now();
            //atualiza OS
            $this->occurrenceRepository->update(['approved' => $data['status'], "approved_date" => Carbon::now()], $occurrence->id);
        } elseif ($data["status"] == 2){
            $data["data_approved"] = Carbon::now();

            //atualiza OS
            $this->occurrenceRepository->update(['approved' => $data['status'], "approved_date" => Carbon::now()], $occurrence->id);
        } elseif ($data["status"] == 3 || $data["status"] == 4){
            //Criar registro na tabela de comunicação
            $data["financial_id"] = $financial->id;
                $this->financialCommunicationRepository->create($data);

            //atualiza OS
            $this->occurrenceRepository->update(['approved' => $data['status']], $occurrence->id);
        }

        return redirect()->route('financials.show', $financial->uuid)->with('message', 'Item criado com sucesso.');
    }


    public function show($financial)
    {
        return view('financials.show', compact('financial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($financial)
    {
        return view('financials.edit', compact('financial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update($financial, $request)
    {
        $data = $request->all();

        /*
         0 - Pendente
         1 - Aprovado
         2 - Reprovado
         3 - Solicitado ajuste
         4 - Ajuste feito pela ECC
        */

        if($data["status"] == 1){
            $data["data_approved"] = Carbon::now();
            //atualiza OS
            $this->occurrenceRepository->update(['approved' => $data['status'], "approved_date" => Carbon::now()], $financial->occurrence->id);
        } elseif ($data["status"] == 2){
            $data["data_approved"] = Carbon::now();

            //atualiza OS
            $this->occurrenceRepository->update(['approved' => $data['status'], "approved_date" => Carbon::now()], $financial->occurrence->id);
        } elseif ($data["status"] == 3 || $data["status"] == 4){
            //atualiza OS
            $this->occurrenceRepository->update(['approved' => $data['status']], $financial->occurrence->id);
        }

        //Criar registro na tabela de comunicação
        $data["financial_id"] = $financial->id;
        $data["user_id"] = \Auth::user()->id;

        $financialCommunication = $this->financialCommunicationRepository->create($data);
        $anexo =  $request->input('anexo');

        try {
            $this->financialRepository->update($data, $financial->id);
            if($anexo){
                if ($anexo && $anexo->getSize() < 10485760){
                    $path = 'communication';
                    $anexoFileName = retira_acentos_espacos($anexo->getClientOriginalName());
                    $financialCommunication->anexo = $this->uploadService->uploadS3($anexo, $path, $anexoFileName);
                    $financialCommunication->anexo_name = $anexo->getClientOriginalName();
                    $financialCommunication->save();
                } else {
                    return redirect()->back()->withInput()->with('error', 'Erro ao tentar anexar arquivo.');
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao tentar editar o item. <br>Erro: '.$e->getMessage());
        }

        return redirect()->route('financials.show',$financial->uuid)->with('message', 'Item atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($financial)
    {
        try {
            $financial->delete();
        } catch (Exception $e) {
            return redirect()->route('financials.index')->with('error', 'Erro ao tentar excluir o item. <br>Erro: '.$e->getMessage());
        }
        return redirect()->route('financials.index')->with('message', 'Item deletado com sucesso.');
    }

    public function dashboard_ajax($request)
    {
         /*
         0 - Pendente
         1 - Aprovado
         2 - Reprovado
         3 - Solicitado ajuste
         4 - Ajuste feito pela ECC
         */

        $sqlWhereContractor = $this->sqlWhereContractor($request);

        return [
            "completeds" => count($this->querySoma("o.approved = 1  AND o.status = 2", $sqlWhereContractor)),
            "reproveds" => count($this->querySoma("o.approved = 2  AND o.status = 2", $sqlWhereContractor)),
            "pendings" => count($this->querySoma("o.approved = 0  AND o.status = 2", $sqlWhereContractor)),
            "toAdjust" => count($this->querySoma("o.approved = 3  AND o.status = 2", $sqlWhereContractor)),
            "toAdjustOk" => count($this->querySoma("o.approved = 4  AND o.status = 2", $sqlWhereContractor)),
        ];

    }

    public function dashboard()
    {
        $contractors = $this->contractorRepository->all();

        $this->occurrenceRepository->pushCriteria(new OccurrenceFinancialDashboardCriteria());

        $occurrences = $this->occurrenceRepository->paginate();
        return view('financials.dashboard', compact('contractors', 'occurrences'));
    }

    private function sqlWhereContractor($request){

        $contractor_id  = $request->input('contractor_id');
        $scheduled_date = $request->input('scheduled_date');

        $sqlWhereContractor = "";


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

    private function querySoma($where,$sqlWhereContractor){

        return DB::select("
            SELECT id FROM `occurrences` o
            WHERE
                $where
                $sqlWhereContractor
            ");
    }

}
