<?php

namespace App\Services;

use App\Repositories\EvaluationRepository;
use App\Repositories\OccurrenceRepository;

class EvaluationService
{
    private $occurrenceRepository;
    private $evaluationRepository;

    public function __construct(
        OccurrenceRepository $occurrenceRepository,
        EvaluationRepository $evaluationRepository
    )
    {
        $this->occurrenceRepository = $occurrenceRepository;
        $this->evaluationRepository = $evaluationRepository;
    }

    public function show($evaluation)
    {
        return view('evaluation.show', compact('evaluation'));
    }


    public function create($occurrence)
    {
        if($occurrence->evaluation == 0){
            return view('evaluation.create', compact('occurrence'));
        }else{
            return view('errors.404_no_btn');
        }
    }

    public function store($request)
    {
        $data = $request->all();
        try{

            $this->evaluationRepository->create($data);
            $this->occurrenceRepository->update(["evaluation" => '1'], $data["occurrence_id"]);
            return view('evaluation.message');

        }catch(\Exception $e){
            return redirect()->route('evaluation.create', $data['occurrence_uuid'])->with("error", "Ocorreu um erro durante a excução");
        }
    }
}
