<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;

/**
 * Class CancelamentoStatusSelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class CancelamentoStatusSelectCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('cancelamento_statuses.*');

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('cancelamento_statuses.id', '=', $id );
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('cancelamento_statuses.name', 'LIKE','%'.$name.'%');
        }

        return $model;
    }
}
