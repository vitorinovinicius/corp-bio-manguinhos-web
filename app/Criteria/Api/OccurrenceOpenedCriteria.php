<?php

namespace App\Criteria\Api;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceOpenedApiCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceOpenedCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model
            ->selectRaw('occurrences.*, occurrence_types.name as occurrenceTypeName')
            ->join('occurrence_types', 'occurrence_types.id', '=' ,'occurrences.occurrence_type_id')
            ->where('status', 1)
            ->where('occurrences.operator_id', $this->user_id)
            ->orderBy('created_at','asc');

        return $model;
    }
}
