<?php

namespace App\Criteria;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrencePendingCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceStatusScheduleCriteria implements CriteriaInterface
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

        //menor que hoje
//        $model->where('occurrences.schedule_date','<',DB::raw('CURDATE()'));


        $model = $model->where('occurrences.status_schedule', 1);

        //Pega os filtros
        criteriaSearch($model);

        $model = $model->orderBy("occurrences.id","DESC");
        return $model;
    }
}
