<?php

namespace App\Services\Api;

use App\Criteria\Api\OccurrenceTypeCriteria;
use App\Http\Resources\Api\OccurrenceTypeResource;
use App\Repositories\OccurrenceTypeRepository;

class OccurrenceTypeService
{
    /**
     * @var OccurrenceTypeRepository
     */
    private $occurrenceTypeRepository;

    /**
     * OccurrenceTypeService constructor.
     * @param OccurrenceTypeRepository $occurrenceTypeRepository
     */
    public function __construct(
        OccurrenceTypeRepository $occurrenceTypeRepository
    )
    {
        $this->occurrenceTypeRepository = $occurrenceTypeRepository;
    }

    public function getOccurrenceType()
    {
        $this->occurrenceTypeRepository->pushCriteria(new OccurrenceTypeCriteria());

        return [
            'occurrence_types' => OccurrenceTypeResource::collection($this->occurrenceTypeRepository->all()),
        ];
    }
}
