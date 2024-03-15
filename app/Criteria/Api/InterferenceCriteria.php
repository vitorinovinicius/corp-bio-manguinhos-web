<?php

namespace App\Criteria\Api;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class InterferenceCriteria.
 *
 * @package namespace App\Criteria\Api;
 */
class InterferenceCriteria implements CriteriaInterface
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
        
        if (\Auth::guard('api')->user()){
            $user = \Auth::guard('api')->user();
        } else {
            $user = \Auth::user();
        }

        $model = $model->where("status", "=", 1);

        return $model;
    }
}
