<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;

/**
 * Class ExpenseTypesCriteriaCriteria.
 *
 * @package namespace App\Criteria;
 */
class ExpenseTypesCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('expense_types.*');

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('expense_types.id', '=', $id);
        }

        $contractor_id = Request::get('contractor_id');
        if (isset($contractor_id) && !empty($contractor_id)) {
            $model->where('expense_types.contractor_id', '=', $contractor_id);
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('expense_types.name', 'like', '%'.$name.'%');
        }
        
        return $model;
    }
}
