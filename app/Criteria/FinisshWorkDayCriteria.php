<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Request;

/**
 * Class FinisshWorkDayCriteria.
 *
 * @package namespace App\Criteria;
 */
class FinisshWorkDayCriteria implements CriteriaInterface
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
        $model = $model
//            ->with(['operator'])
            ->selectRaw('finish_work_days.*');


        $operator_id = Request::get('operator_id');
        if (isset($operator_id) && !empty($operator_id)) {
            if ($operator_id == "x") {
                $model->where('finish_work_days.operator_id', '=', null);
            } else {
                $model->where('finish_work_days.operator_id', '=', $operator_id);
            }
        }
        $contractor_id = Request::get('contractor_id');
        if (isset($contractor_id) && !empty($contractor_id)) {
            $model->where('finish_work_days.contractor_id', '=', $contractor_id);
        }
        $date_record = Request::get('date_record');
        if (isset($date_record) && !empty($date_record)) {
            $date_record = format_range_to_database($date_record);
            $model->whereBetween('finish_work_days.date_record', [$date_record[0], $date_record[1]]);
        }
        $model->orderBy("id","DESC");

        return $model;
    }
}
