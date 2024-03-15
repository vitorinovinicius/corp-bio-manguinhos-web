<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\FormService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    /**
     * @var FormService
     */
    private $formService;


    /**
     * FormController constructor.
     * @param FormService $formService
     */
    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    public function getForms(Request $request)
    {
        return $this->formService->getForms($request);
    }

    public function getVersions(Request $request){
        return $this->formService->getVersions($request);
    }
}
