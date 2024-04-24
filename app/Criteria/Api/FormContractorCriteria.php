<?php

namespace App\Criteria\Api;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FormContractorCriteria.
 *
 * @package namespace App\Criteria;
 */
class FormContractorCriteria implements CriteriaInterface
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
        if (\Auth::user()->contractor_id) {
            $model = $model->where("empresa_id","=", \Auth::user()->empresa_id);
        }
        return $model;
    }
}
