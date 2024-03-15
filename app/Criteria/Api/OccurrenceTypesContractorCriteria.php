<?php

namespace App\Criteria\Api;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceTypeCriteriaCriteria.
 *
 * @package namespace App\Criteria\Api;
 */
class OccurrenceTypesContractorCriteria implements CriteriaInterface
{

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

        $model->orderBy("id","desc");

        return $model;
    }
}
