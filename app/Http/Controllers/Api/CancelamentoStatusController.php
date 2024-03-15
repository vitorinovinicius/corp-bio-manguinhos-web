<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\CancelamentoStatusService;

class CancelamentoStatusController extends Controller
{

    /**
     * @var CancelamentoStatusService
     */
    private $cancelamentoStatusService;

    /**
     * CancelamentoStatusController constructor.
     */
    public function __construct(CancelamentoStatusService $cancelamentoStatusService)
    {
        $this->cancelamentoStatusService = $cancelamentoStatusService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function download()
    {
        return $this->cancelamentoStatusService->download();
    }
}
