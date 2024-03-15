<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrencePlanOccurrenceCriteria.
 *
 * @package namespace App\Criteria;
 */
class OccurrencePlanOccurrenceCriteria implements CriteriaInterface
{
    private $planOccurrence;

    /**
     * OccurrencePlanOccurrenceCriteria constructor.
     * @param $planOccurrence
     */
    public function __construct($planOccurrence)
    {
        $this->planOccurrence = $planOccurrence;
    }
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->selectRaw('occurrences.*');

        $model->where('occurrences.contractor_id', '=', $this->planOccurrence->contractor_id );
        $model->where('occurrences.occurrence_type_id', '=', $this->planOccurrence->occurrence_type_id);
        $model->where('occurrences.occurrence_client_id', '=', $this->planOccurrence->occurrence_client_id);
        $model->where('occurrences.plan_occurrence_id', '=', $this->planOccurrence->id);

        $model->orderBy('schedule_date', 'desc');
//        $model->orderBy('id', 'desc');

        return $model;
    }
}
