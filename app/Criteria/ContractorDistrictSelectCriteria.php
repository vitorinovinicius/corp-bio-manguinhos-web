<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ContractorDistrictSelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class ContractorDistrictSelectCriteria implements CriteriaInterface
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

        $contractor_id = Request::get('contractor_id');
        if(isset($contractor_id) && !empty($contractor_id)){
            $model = $model->where('contractor_id', '=', $contractor_id);
        }

        $district_id = Request::get('district_id');
        if(isset($district_id) && !empty($district_id)){
            $model = $model->where('district_id', '=', $district_id);
        }

        $model = $model->orderBy('contractor_id','ASC');

        return $model;
    }
}
