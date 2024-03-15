<?php

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceFinancialDashboardCriteria.
 *
 * @package namespace App\Criteria;
 */
class OccurrenceFinancialDashboardCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('occurrences.*');

        $model->where("occurrences.status","=",2); // realizado

        if (!\Request::get('scheduled_date')) {
            $model->where('occurrences.schedule_date', Carbon::today());
        }

        //Pega os filtros
        criteriaSearch($model);


        $model = $model
            ->orderBy("occurrences.check_out","DESC");

        return $model;
    }
}
