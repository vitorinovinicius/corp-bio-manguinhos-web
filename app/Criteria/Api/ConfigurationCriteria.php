<?php

namespace App\Criteria\Api;

use Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ConfigurationCriteria.
 *
 * @package namespace App\Criteria\Api;
 */
class ConfigurationCriteria implements CriteriaInterface
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
        $user = Auth::guard('api')->user();

        $model = $model->where("contractor_id",$user->contractor_id)->orWhere("contractor_id",null);

        return $model;
    }
}
