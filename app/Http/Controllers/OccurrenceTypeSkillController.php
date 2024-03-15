<?php

namespace App\Http\Controllers;

use App\Models\OccurrenceType;
use App\Services\OccurrenceTypeSkillService;
use Illuminate\Http\Request;

class OccurrenceTypeSkillController extends Controller
{
    /**
     * @var OccurrenceTypeSkillService
     */
    private $occurrenceTypeSkillService;

    /**
     * OccurrenceTypeSkillController constructor.
     * @param OccurrenceTypeSkillService $occurrenceTypeSkillService
     */
    public function __construct(OccurrenceTypeSkillService $occurrenceTypeSkillService)
    {
        $this->occurrenceTypeSkillService = $occurrenceTypeSkillService;
    }


    public function associate_skill(OccurrenceType $occurrence_type)
    {
        return $this->occurrenceTypeSkillService->associate_skill($occurrence_type);
    }

    public function associate_skill_store(OccurrenceType $occurrence_type, Request $request)
    {
        return $this->occurrenceTypeSkillService->sync_skill_store($occurrence_type, $request, $flag = 1);
    }

    public function disassociate_skill(OccurrenceType $occurrence_type)
    {
        return $this->occurrenceTypeSkillService->disassociate_skill($occurrence_type);
    }

    public function disassociate_skill_store(OccurrenceType $occurrence_type, Request $request)
    {
        return $this->occurrenceTypeSkillService->sync_skill_store($occurrence_type, $request, $flag = 2);
    }
}
