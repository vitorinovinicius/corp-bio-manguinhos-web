<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;

/**
 * Class PlanOccurrenceCreateCriteria.
 *
 * @package namespace App\Criteria;
 */
class PlanOccurrenceCreateCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('plan_occurrences.*');

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('plan_occurrences.id', '=', $id );
        }

        // if (\Auth::user()->contractor_id) {
        //     $contractorId = \Auth::user()->contractor_id;
        // } else {
        //     $contractorId = Request::get('contractor_id');
        // }
        // if (isset($contractorId) && !empty($contractorId)) {
        //     $model->where('plan_occurrences.contractor_id', '=', $contractorId );
        // }

        $occurrenceTypeId = Request::get('occurrence_type_id');
        if (isset($occurrenceTypeId) && !empty($occurrenceTypeId)) {
            $model->where('plan_occurrences.occurrence_type_id', '=', $occurrenceTypeId );
        }

        $operatorId = Request::get('operator_id');
        if (isset($operatorId) && !empty($operatorId)) {
            $model->where('plan_occurrences.operator_id', '=', $operatorId );
        }

        $status = Request::get('status');
        if (isset($status) && !empty($status)) {
            $model->where('plan_occurrences.status', '=', $status );
        }

        $weekend = Request::get('weekend');
        if (isset($weekend) && !empty($weekend)) {
            $model->where('plan_occurrences.weekend', '=', $weekend );
        }

        $dateBegin = Request::get('date_begin');
        if (isset($dateBegin) && !empty($dateBegin)) {
            $model->where('plan_occurrences.date_begin', '=', $dateBegin );
        }

        $dateFinish = Request::get('date_finish');
        if (isset($dateFinish) && !empty($dateFinish)) {
            $model->where('plan_occurrences.date_finish', '=', $dateFinish );
        }

        $model->where('plan_occurrences.status','=',1);

        $model->distinct();

        return $model;
    }

}
