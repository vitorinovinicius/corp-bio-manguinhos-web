<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;
use App\Models\Sms;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    /**
     * @var SmsService
     */
    private $smsService;

    /**
     * SmsController constructor.
     * @param SmsService $smsService
     */
    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->smsService->index($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Sms $model)
    {
        return $this->smsService->show($model);
    }

    /**
     * @param Occurrence $occurrence
     */
    public function enviaSms(Occurrence $occurrence){
        return $this->smsService->enviaSms($occurrence);
    }

    /**
     * @param Request $request
     */
    public function recebeStatus(Request $request){
        return $this->smsService->recebeStatus($request);
    }
}
