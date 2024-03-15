<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LogLocalService;
use Illuminate\Http\Request;

class LogController extends Controller
{

    /**
     * @var LogLocalService
     */
    private $logLocalService;

    public function __construct(LogLocalService $logLocalService)
    {
        $this->logLocalService = $logLocalService;
    }

    public function updateLog(Request $request){
        return $this->logLocalService->save($request);
    }

}
