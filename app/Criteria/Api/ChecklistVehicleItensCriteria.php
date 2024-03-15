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
class ChecklistVehicleItensCriteria implements CriteriaInterface
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
            $contractor_id = $operator->contractor_id;

        $model = $model->where(function ($query) use ($vehicle, $contractor_id) {
                $query->where('type_id', '=', $vehicle->type)
                    ->where('contractor_id', '=', $contractor_id)
                    ->orWhere('type_id', '=', 3);
            });

        return $model;
    }
}
