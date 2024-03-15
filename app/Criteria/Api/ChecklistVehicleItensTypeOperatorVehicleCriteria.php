<?php

namespace App\Criteria\Api;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OperatorMoveCriteria.
 *
 * @package namespace App\Criteria;
 */
class ChecklistVehicleItensTypeOperatorVehicleCriteria implements CriteriaInterface
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


        $dataIni = date("Y-m-d") . " 00:00:00";
            $dataFim = date("Y-m-d") . " 23:59:59";

            $model = $model->whereBetween('created_at', [$dataIni,$dataFim]);

        return $model;
    }
}
