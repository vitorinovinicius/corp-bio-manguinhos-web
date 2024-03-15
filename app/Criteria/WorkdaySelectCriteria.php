<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Request;

/**
 * Class WorkdaySelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class WorkdaySelectCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('workdays.*');

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('workdays.id', '=', $id );
        }

        $contractor = Request::get('contractor_id');
        if (isset($contractor) && !empty($contractor)) {
            $model->where('workdays.contractor_id', '=' , $contractor);
        }else{
            
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('workdays.name', 'like' , '%'.$name.'%');
        }

        $status = Request::get('status');
        if (isset($status) && !empty($status)) {
            $model->where('workdays.status', '=' , $status);
        }

        return $model;
    }
}
