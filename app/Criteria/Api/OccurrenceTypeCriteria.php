<?php

namespace App\Criteria\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceOrderCriteria
 * @package namespace Bureau\Criteria;
 */
class OccurrenceTypeCriteria implements CriteriaInterface
{

    /**
     * OccurrenceOrderCriteria constructor.
     */
    public function __construct()
    {
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixedx
     */
    public function apply($model, RepositoryInterface $repository)
    {

        $model = $model->where('status',1);
        if (\Auth::user()->contractor_id) {
            $model->where("contractor_id","=", \Auth::user()->contractor_id);
        }

        $model->orderBy('name', 'ASC');

        return $model;
    }
}
