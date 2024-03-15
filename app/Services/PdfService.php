<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06/05/2019
 * Time: 16:32
 */

namespace App\Services;

use App\Repositories\FormGroupRepository;
use App\Repositories\ExpenseRepository;
use App\Criteria\RepaymentPdfCriteria;

class PdfService
{
    private $expenseRepository;
    /**
     * @var FormGroupRepository
     */
    private $formGroupRepository;


    /**
     * PdfService constructor.
     * @param FormGroupRepository $formGroupRepository
     */
    public function __construct(FormGroupRepository $formGroupRepository, ExpenseRepository $expenseRepository)
    {
        $this->formGroupRepository = $formGroupRepository;
        $this->expenseRepository = $expenseRepository;
    }

    public function getPdfOccurence($occurrence, $image = '', $formId = '')
    {
      
        \Debugbar::disable();
        // return view('occurrences.pdf', compact('occurrence', 'image'));
        return view('pdfs.pdf_os', compact('occurrence', 'image', 'formId'));

    }

    public function getPdfChecklistVehicle($vehicleChecklistBasic)
    {

        $form_groups = $this->formGroupRepository->all();

        \Debugbar::disable();
        return view('vehicles.pdf', compact('vehicleChecklistBasic', 'form_groups'));

    }

    public function getPdfRepayment($request)
    {
        $data = $request->all();

        $contractor_id = (isset($data["contract"])) ? $data["contract"] : null;
        $user_id = ($data["operator"]) ? $data["operator"] : null;
        $dateIn = ($data["dateIn"]) ? $data["dateIn"] : null;
        $dateFn = ($data["dateFn"]) ? $data["dateFn"] : null;

        $expenses = $this->expenseRepository->pushCriteria(new RepaymentPdfCriteria($contractor_id, $user_id, $dateIn, $dateFn))->all();

        $valueTotal = $expenses->sum('value');
        $paidOutValueTotal = $expenses->where('status', '=', 2)->sum('value');
        $pendingValueTotal = $expenses->where('status', '=', 1)->sum('value');
        $refusedValueTotal = $expenses->where('status', '=', 3)->sum('value');
        $inactiveValueTotal = $expenses->where('status', '=', 4)->sum('value');

        $aExpenses = [];
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

        return view('repayment.pdf', compact(
            'expenses',
            'aExpenses',
            'dateIn',
            'dateFn',
            'valueTotal',
            'paidOutValueTotal',
            'pendingValueTotal',
            'refusedValueTotal',
            'inactiveValueTotal'
        ));

    }

}
