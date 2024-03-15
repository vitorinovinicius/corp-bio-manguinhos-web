<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceClosedUnsolvedCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceClosedUnsolvedCriteria implements CriteriaInterface
{
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
        $model = $model->selectRaw('occurrences.*');

        $model = $model->where("occurrences.status","=",3);

        //Pega os filtros
        criteriaSearch($model);

        $model = $model->orderBy("occurrences.id","DESC");
        return $model;
    }
}
