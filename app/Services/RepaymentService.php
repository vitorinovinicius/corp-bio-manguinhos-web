<?php

namespace App\Services;


use App\Criteria\RepaymentCriteria;
use App\Repositories\ExpenseRepository;
use App\Criteria\OperatorAjaxCriteria;
use Carbon\Carbon;
use Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Repositories\UserRepository;

class RepaymentService
{
    private $expenseRepository;
    private $userRepository;

    public function __construct(ExpenseRepository $expenseRepository, UserRepository $userRepository)
    {
       $this->expenseRepository = $expenseRepository;
       $this->userRepository = $userRepository;
    }

    public function listRepayment()
    {
        $expenses = $this->expenseRepository->pushCriteria(new RepaymentCriteria())->all();

        $request = Request::all();

        $contractor_id = (isset($request["contractor_id"])) ? $request["contractor_id"] : \Auth::user()->contractor_id;
        $user_id = (isset($request["user_id"])) ? $request["user_id"] : '';

        $operators = '';

        if(\Auth::user()->contractor_id){
            $id = \Auth::user()->contractor_id;
            $operators = $this->userRepository->pushCriteria(new OperatorAjaxCriteria($id))->all();
        }

        if(empty($request["scheduled_date"])){
            $dateFn = Carbon::now()->format('d-m-Y');
            $dateIn = Carbon::now()->subMonth()->format('d-m-Y');
            $scheduled_date = $dateIn .' - '. $dateFn;
        }else{
            $scheduled_date = $request["scheduled_date"];
            $explodData = explode("-", $scheduled_date);
            $dateIn = Carbon::createFromFormat('d/m/Y', trim($explodData[0]))->format('d-m-Y');
            $dateFn = Carbon::createFromFormat('d/m/Y', trim($explodData[1]))->format('d-m-Y');
        }

        $total = '';
        $paidOut = '';
        $pending = '';
        $refused = '';
        $inactive = '';
        $valueTotal = '';
        $paidOutValueTotal = '';
        $pendingValueTotal = '';
        $refusedValueTotal = '';
        $inactiveValueTotal = '';
        $aExpenses = [];

        if($expenses->count() > 0){
            $total = $expenses->count();
            $paidOut = (($expenses->where('status', '=', 2)->count())/$total) * 100; //pago
            $pending = (($expenses->where('status', '=', 1)->count())/$total) * 100; // pendente
            $refused = (($expenses->where('status', '=', 3)->count())/$total) * 100; // recusado
            $inactive =(($expenses->where('status', '=', 4)->count())/$total) * 100; // Invalidas

            $valueTotal = $expenses->sum('value');
            $paidOutValueTotal = $expenses->where('status', '=', 2)->sum('value');
            $pendingValueTotal = $expenses->where('status', '=', 1)->sum('value');
            $refusedValueTotal = $expenses->where('status', '=', 3)->sum('value');
            $inactiveValueTotal = $expenses->where('status', '=', 4)->sum('value');

            $indice = 0;
            $total = 0.0;
            $datei = $expenses[0]->date;
            for($i=0; $i < $expenses->count(); $i++){
                if($expenses[$i]->date != $datei){
                    $indice++;
                    $total = 0;
                    $datei = $expenses[$i]->date;
                }

                $value = $expenses[$i]->value;
                $total = $total + $value;

                $aExpenses[$indice]['expenses'][] = $expenses[$i];
                $aExpenses[$indice]['total'] = $total;

            }

        }

        return view('repayment.show', compact(
            'contractor_id',
            'user_id',
            'expenses',
            'dateIn',
            'dateFn',
            'paidOut',
            'pending',
            'refused',
            'inactive',
            'aExpenses',
            'valueTotal',
            'paidOutValueTotal',
            'pendingValueTotal',
            'refusedValueTotal',
            'inactiveValueTotal',
            'operators'
        ));
    }

    public function pdf(\Illuminate\Http\Request $request)
    {
        $data = $request->all();       

        $contractor_id = (isset($data["contract"])) ? $data["contract"] : null;
        $user_id = ($data["operator"]) ? $data["operator"] : null;
        $dateIn = ($data["dateIn"]) ? $data["dateIn"] : null;
        $dateFn = ($data["dateFn"]) ? $data["dateFn"] : null;

        return PDF::loadFile(str_replace('/admin/repayment', 'repayment', request()->fullUrl()))->inline($contractor_id.'_'.$user_id.'_'.$dateIn.'_'.$dateFn . '.pdf');
    }

}
