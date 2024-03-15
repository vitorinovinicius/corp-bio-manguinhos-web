<?php

namespace App\Http\Controllers;

use App\Services\RepaymentService;
use Illuminate\Http\Request;


class RepaymentController extends Controller
{
    private $repaymentService;

    public function __construct(RepaymentService $repaymentService)
    {
        $this->repaymentService = $repaymentService;

    }

    public function index()
    {
        return $this->repaymentService->listRepayment();
    }

    public function pdf(Request $request)
    {
        return $this->repaymentService->pdf($request);
    }

    public function excel(Request $request)
    {
        return $this->repaymentService->excel($request);
    }


}
