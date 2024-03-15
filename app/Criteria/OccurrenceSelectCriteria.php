<?php

namespace App\Criteria;

use Artesaos\Defender\Facades\Defender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceSelectCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceSelectCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->selectRaw('occurrences.*');

        //Pega os filtros
        criteriaSearch($model);

        $model->orderBy("occurrences.schedule_date","DESC");
//        $model->orderBy("occurrences.occurrence_type_id","ASC");
        $model->orderBy("occurrences.priority","DESC");
        $model->orderBy("occurrences.id", "DESC");

        return $model;
    }
}
