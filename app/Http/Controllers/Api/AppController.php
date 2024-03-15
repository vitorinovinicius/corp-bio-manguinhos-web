<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AppService;

class AppController extends Controller
{

    private $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    public function atualizaApp($version){
        return $this->appService->atualizaApp($version);
    }

}
