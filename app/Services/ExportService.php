<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24/05/2017
 * Time: 12:18
 */

namespace App\Services;


use App\Criteria\OccurrenceCityCriteria;
use App\Criteria\OccurrenceTypeCriteria;
use App\Criteria\OperatorSelectCriteria;
use App\Exports\OccurrenceExport;
use App\Models\CancelamentoStatus;
use App\Models\Occurrence;
use App\Models\User;
use App\Repositories\ContractorRepository;
use App\Repositories\InterferenceRepository;
use App\Repositories\OccurrenceClientRepository;
use App\Repositories\OccurrenceTypeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Criteria\RepaymentCriteria;
use App\Repositories\ExpenseRepository;
use App\Exports\RepaymentExport;
use App\Exports\OperatorExport;


class ExportService
{
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
     * @var ContractorRepository
     */
    private $contractorRepository;
    /**
     * @var ExpenseRepository
     */
    private $expenseRepository;
    /**
     * @var InterferenceRepository
     */
    private $interferenceRepository;

    /**
     * ExportService constructor.
     * @param UserRepository $userRepository
     * @param OccurrenceClientRepository $occurrenceClientRepository
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     * @param ContractorRepository $contractorRepository
     * @param ExpenseRepository $expenseRepository
     * @param InterferenceRepository $interferenceRepository
     */
    public function __construct(
        UserRepository $userRepository,
        OccurrenceClientRepository $occurrenceClientRepository,
        OccurrenceTypeRepository $occurrenceTypeRepository,
        ContractorRepository $contractorRepository,
        ExpenseRepository $expenseRepository,
        InterferenceRepository $interferenceRepository
    ){

        $this->userRepository = $userRepository;
        $this->occurrenceClientRepository = $occurrenceClientRepository;
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
        $this->contractorRepository = $contractorRepository;
        $this->expenseRepository = $expenseRepository;
        $this->interferenceRepository = $interferenceRepository;
    }

    public function index(){
        $this->userRepository->pushCriteria(new OperatorSelectCriteria());
        $operators = $this->userRepository->all();

        $this->occurrenceClientRepository->pushCriteria(new OccurrenceCityCriteria());
        $occurrence_clients = $this->occurrenceClientRepository->all();

        $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria());
        $occurrence_types = $this->occurrenceTypeRepository->all();
        $motivos = CancelamentoStatus::get();
        $contractors = $this->contractorRepository->all();

        $interferences = $this->interferenceRepository->findWhere(["status" => 1])->all();

        $user = new User();
        $programmers = $user->scopeRole(5)->get();

        return view("export.index",compact('operators','occurrence_clients', 'operators', 'occurrence_types', 'programmers', 'motivos','contractors','interferences'));
    }

    public function index_financeiro_cs(){

        $contractors = $this->contractorRepository->all();

        return view("export.financeiro_cs",compact('contractors'));
    }

    public function export(Request $request)
    {

        $model = Occurrence::selectRaw('occurrences.*')->with('occurrence_client.occurrence_client_phones');

        $city           = $request->get('city');
        $district       = $request->get('district');
        $address        = $request->get('address');
        $client_number  = $request->get('client_number');
        $search         = $request->get('search');

        if(
            (isset($city) && !empty($city)) OR
            (isset($district) && !empty($district)) OR
            (isset($address) && !empty($address)) OR
            (isset($client_number) && !empty($client_number)) OR
            (isset($search) && !empty($search))
        ){
            $model->join('occurrence_clients', 'occurrences.occurrence_client_id', '=' ,'occurrence_clients.id');

        }

        /*
               * Caso seja role regiao pegar apenas tecnicos das empreiteiras que atendem a regiao que posso ver..
               */
        /*
         * VERIFICAR A FOMRMA CORRETA DE SEPARAR AS REGIÕES JÁ QUE AGORA TEMPOS TAMBÉM O organizacao_id
        $regionsUser    = \Auth::user()->regions->implode('id',',');
        $regiaoRole     = \Auth::user()->hasRole('regiao');

        if($regiaoRole) {
            $model->whereIn('occurrences.region_id',[$regionsUser]);
        }
        */

        if(!$request->get("scheduled_date")){
//            return response()->json(['error' => "Período não informado"], 500);
            return redirect()->back()->withInput()->with('error', 'Período não informado');
        }

        $date_diff = format_range_to_database($request->get("scheduled_date"));
        if($date_diff[0]->diffInDays($date_diff[1]) > 31){
            return redirect()->back()->withInput()->with('error', 'Período maior que 31 dias')->withInput();
        }

        //Pega os filtros
        criteriaSearch($model);

        $model->orderBy("occurrences.schedule_date","ASC");
        $occurrences = $model->get();

        $data = array();

        $totalOs = $occurrences->count();

        if($totalOs == 0) {
//            return response()->json(['error' => "Nenhuma os encontrada"], 500);

            return redirect()->back()->withInput()->with('error', 'Nenhuma os encontrada');
        }

        return Excel::download(new OccurrenceExport($occurrences), "Central System - Exportação de Ocorrências.xlsx");

    }

    public function exportRepayment(Request $request)
    {
        $expenses = $this->expenseRepository->pushCriteria(new RepaymentCriteria())->all();

        return Excel::download(new RepaymentExport($expenses), "Central System - Exportação de Reembolso.xlsx");

    }

    public function operator(Request $request)
    {
        $expenses = $this->userRepository->pushCriteria(new OperatorSelectCriteria())->all();

        return Excel::download(new OperatorExport($expenses), "Central System - Exportação de Técnico.xlsx");

    }


}
