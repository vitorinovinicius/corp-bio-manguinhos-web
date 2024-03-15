<?php

namespace App\Criteria;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceAssignedCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceUnassignedCriteria implements CriteriaInterface
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
        $model->where('occurrences.schedule_date', '>=', DB::raw('CURDATE()'));

        if(isset($mercado) && !empty($mercado)){
            $model->join('occurrence_data_basics', 'occurrences.id', '=' ,'occurrence_data_basics.occurrence_id');
        }


        $model->where(["occurrences.status"=>1]);
        $model->where(["occurrences.operator_id"=>null]);

        //Pega os filtros
        criteriaSearch($model);


        $ordenar = Request::get('ordenar');
        if(isset($ordenar) && !empty($ordenar)){
            $model->orderBy("occurrence_clients.".$ordenar,"ASC")
                ->orderBy("occurrences.id","DESC");
        }else{
            $model->orderBy("occurrences.schedule_date","DESC");
            $model->orderBy("occurrences.occurrence_type_id","ASC");
            $model->orderBy("occurrences.priority","DESC");
            $model->orderBy("occurrences.id", "DESC");

        }

        return $model;
    }
}
