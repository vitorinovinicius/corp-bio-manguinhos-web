<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Request;

/**
 * Class WorkdayProgramsCriteria.
 *
 * @package namespace App\Criteria;
 */
class WorkdayProgramsCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('workday_programs.*');
       

        $workday_id = Request::get('workday_id');
        if (isset($workday_id) && !empty($workday_id)) {
            $model->where('workday_programs.workday_id', '=', $workday_id );
        }
        return $model;
    }
}
