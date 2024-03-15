<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Services\EvaluationService;

class EvaluationController extends Controller
{
    private $evaluationService;

    public function __construct(EvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;    
    }

    public function show(Evaluation $evaluation)
    {
        return $this->evaluationService->show($evaluation);
    }

    public function create($occurrence)
    {
        return $this->evaluationService->create($occurrence);
    }

    public function store(Request $request)
    {
        return $this->evaluationService->store($request);
    }
}