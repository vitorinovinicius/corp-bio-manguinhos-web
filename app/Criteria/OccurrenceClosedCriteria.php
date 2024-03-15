<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceClosedCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceClosedCriteria implements CriteriaInterface
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

         $model = $model->where("occurrences.status","=",2); // realizado


        //Pega os filtros
        criteriaSearch($model);

        $model = $model
            ->orderBy("occurrences.check_out","DESC");
        return $model;
    }
}
