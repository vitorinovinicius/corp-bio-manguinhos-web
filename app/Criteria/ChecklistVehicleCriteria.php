<?php

namespace App\Criteria;

use App\Models\Vehicle;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Request;

/**
 * Class VehicleCriteria.
 *
 * @package namespace App\Criteria;
 */
class ChecklistVehicleCriteria implements CriteriaInterface
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
//        $model = $model->with(['contractor']);

        $model->orderBy("id","desc");

        return $model;
    }
}
