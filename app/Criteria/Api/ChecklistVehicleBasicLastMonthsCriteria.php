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
class ChecklistVehicleBasicLastMonthsCriteria implements CriteriaInterface
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

            $lastMonth = Carbon::now()->subMonth(6)->format("Y-m");
            $today = Carbon::now()->format("Y-m");

            $model = $model->whereBetween('finish_date', [$lastMonth. "-01 00:00:00", $today . "-31 23:59:59"]);
            $model->where('type_id', '=', $vehicle->type);
            $model->where('condutor_id', '=', $operator->id);
            $model->where('vehicle_id', '=', $vehicle->id);

        return $model;
    }
}
