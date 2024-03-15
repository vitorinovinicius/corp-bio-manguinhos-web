<?php

namespace App\Criteria;

use Artesaos\Defender\Facades\Defender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrencePendingCriteria
 * @package namespace App\Criteria;
 */
class OccurrencePendingCriteria implements CriteriaInterface
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


        //igual ou maior que hoje
//        $model->where('occurrences.schedule_date', '>=', DB::raw('CURDATE()'));

        $model = $model->where(["occurrences.status" => 1])
            ->where("occurrences.operator_id", "<>", null)
            ->where("occurrences.operator_id", "<>", "");


        //Pega os filtros
        criteriaSearch($model);

        $model->orderBy("occurrences.schedule_date","DESC");
        $model->orderBy("occurrences.occurrence_type_id","ASC");
        $model->orderBy("occurrences.priority","DESC");
        $model->orderBy("occurrences.id", "DESC");
        return $model;
    }
}
