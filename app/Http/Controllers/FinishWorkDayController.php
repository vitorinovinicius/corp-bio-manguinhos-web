<?php

namespace App\Http\Controllers;

use App\Models\FinishWorkDay;
use App\Services\FinishWorkDayService;
use Illuminate\Http\Request;

class FinishWorkDayController extends Controller
{

    /**
     * @var LogLocalService
     */
    private $finishWorkDayService;

    /**
     * LogLocalController constructor.
     */
    public function __construct(FinishWorkDayService $finishWorkDayService)
    {
        $this->finishWorkDayService = $finishWorkDayService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->finishWorkDayService->index($request);
    }

    /**
     * Display the specified resource.
     *
     * @param LogLocal $model
     * @return Response
     */
    public function show(FinishWorkDay $finishWorkDay)
    {
        return $this->finishWorkDayService->show($finishWorkDay);
    }
}
