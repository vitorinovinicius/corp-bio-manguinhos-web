<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;

/**
 * Class CategoryCriteria.
 *
 * @package namespace App\Criteria;
 */
class CategoryCriteria implements CriteriaInterface
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
//             ->with('contractor')
             ->selectRaw('categories.*')
         ;

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('categories.id', '=', $id );
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('categories.name', 'LIKE','%'.$name.'%');
        }

        $status = Request::get('status');
        if (isset($status) && !empty($status)) {
            $model->where('categories.status', '=', $status);
        }

        $contractor_id = Request::get('contractor_id');
        if (isset($contractor_id) && !empty($contractor_id)) {
            $model->where('categories.contractor_id', '=', $contractor_id);
        }

        return $model;
    }
}
