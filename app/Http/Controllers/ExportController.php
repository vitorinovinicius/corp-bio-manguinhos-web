<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * @var ExportService
     */
    private $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function index()
    {
        return $this->exportService->index();
    }

    public function financeiro_cs()
    {
        return $this->exportService->index_financeiro_cs();
    }

    public function export(Request $request){
        return $this->exportService->export($request);
    }

    public function exportRepayment(Request $request)
    {
        return $this->exportService->exportRepayment($request);
    }
    
    public function operator(Request $request)
    {
        return $this->exportService->operator($request);
    }
}
