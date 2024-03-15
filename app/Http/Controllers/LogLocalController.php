<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\LogLocal;
use App\Services\LogLocalService;
use Illuminate\Http\Request;

class LogLocalController extends Controller {

    /**
     * @var LogLocalService
     */
    private $logLocalService;

    /**
     * LogLocalController constructor.
     */
    public function __construct(LogLocalService $logLocalService)
    {
        $this->logLocalService = $logLocalService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->logLocalService->index($request);
    }

    /**
     * Display the specified resource.
     *
     * @param LogLocal $model
     * @return Response
     */
    public function show(LogLocal $model)
    {
        return $this->logLocalService->show($model);
    }


}
