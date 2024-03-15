<?php

namespace App\Criteria\Api;

use Auth;
use Carbon\Carbon;
use DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OperatorMoveCriteria.
 *
 * @package namespace App\Criteria;
 */
class ChecklistVehicleBasicMonthCriteria implements CriteriaInterface
{

    public function __construct()
    {
    }

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
            $operator = Auth::user();
            $vehicle = $operator->vehicle;

            $today = Carbon::now()->format("Y-m");

            $model = $model->whereBetween('finish_date', [$today. "-01 00:00:00", $today . "-31 23:59:59"]);
            $model->where(function ($query) use ($vehicle) {
                $query->where('type_id', '=', $vehicle->type)
                    ->orWhere('type_id', '=', 3);
            });

        return $model;
    }
}
