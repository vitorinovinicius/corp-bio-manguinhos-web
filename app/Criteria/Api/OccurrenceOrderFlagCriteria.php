<?php

namespace App\Criteria\Api;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Auth;
use Carbon\Carbon;

/**
 * Class OccurrenceOrderFlagCriteria.
 *
 * @package namespace App\Criteria\Api;
 */
class OccurrenceOrderFlagCriteria implements CriteriaInterface
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

        $operator_id = Auth::guard('api')->user()->id;

        $model = $model
            ->selectRaw('occurrences.*, occurrence_orders.flag')
            ->leftjoin('occurrence_orders', 'occurrences.operator_id', '=', 'occurrence_orders.operator_id')
            ->where('occurrence_orders.flag_date','=', Carbon::today())
            ->where('occurrence_orders.order_app','=', false)
            ->where('occurrence_orders.operator_id','=', $operator_id)
            ->whereRaw('occurrence_orders.flag > occurrences.order_flag')
            ->where('occurrences.schedule_date','=', Carbon::today())
            ->distinct()
            ->orderBy('occurrences.order_client', 'ASC');

        return $model;



    }
}
