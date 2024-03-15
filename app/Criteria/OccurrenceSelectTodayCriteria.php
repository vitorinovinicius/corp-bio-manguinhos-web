<?php

namespace App\Criteria;

use Artesaos\Defender\Facades\Defender;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceSelectCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceSelectTodayCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->selectRaw('occurrences.*');

        if (!Request::get('scheduled_date') || empty(Request::get('scheduled_date'))) {
            $model->where('occurrences.schedule_date', Carbon::today());
        }
        //Pega os filtros
        criteriaSearch($model);


        $model = $model->orderBy("occurrences.schedule_date", "DESC");
        $model = $model->orderBy("occurrences.id", "DESC");

        $model->distinct();

        return $model;
    }
}
