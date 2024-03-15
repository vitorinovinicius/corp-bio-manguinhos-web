<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\OperatorOccurrenceRepository;

class OperatorOccurrenceService
{
    public function __construct(  
        OperatorOccurrenceRepository $operatorOccurrenceRepository
       )
    {
        $this->OperatorOccurrenceRepository = $operatorOccurrenceRepository;
        
    }

    public function update(Request $request)
    {
        dd($request);
    }

    

}
