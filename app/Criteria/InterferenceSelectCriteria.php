<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;
/**
 * Class InterferenceSelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class InterferenceSelectCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('interferences.*');

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('interferences.id', '=', $id );
        }

        $description = Request::get('description');
        if (isset($description) && !empty($description)) {
            $model->where('interferences.description', 'LIKE','%'.$description.'%');
        }

        $status = Request::get('status');
        if (isset($status) && $status != null) {
            $model->where('interferences.status', '=',$status);
        }

        return $model;
    }
}
