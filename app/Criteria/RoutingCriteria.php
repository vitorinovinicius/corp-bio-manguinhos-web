<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Request;

/**
 * Class RoutingCriteria.
 *
 * @package namespace App\Criteria;
 */
class RoutingCriteria implements CriteriaInterface
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
//            ->with(['contractor', 'operator'])
            ->selectRaw('routings.*')
        ;

        $contractor = Request::get('contractor_id');
        if (isset($contractor) && !empty($contractor)) {
            $model->where('routings.contractor_id', '=' , $contractor);
        }

        $operator = Request::get('operator_id');
        if (isset($operator) && !empty($operator)) {
            $model->where('routings.operator_id', '=' , $operator);
        }

        $routingDate = Request::get('routing_date');
        if (isset($routingDate) && !empty($routingDate)) {
//            $model->where('routings.routing_date', '=' , $routingDate.'%');
            $model->where('routings.routing_date', 'like' , '%'.$routingDate.'%');
        }

        return $model;
    }
}
