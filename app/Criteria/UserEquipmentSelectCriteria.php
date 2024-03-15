<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;

/**
 * Class UserEquipmentSelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserEquipmentSelectCriteria implements CriteriaInterface
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
        $model = $model->where("user_id", "=", null);

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('equipments.id', '=', $id );
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('equipments.name', 'LIKE','%'.$name.'%');
        }

        $type = Request::get('type');
        if (isset($type) && !empty($type)) {
            $model->where('equipments.type', 'LIKE','%'.$type.'%');
        }


        return $model;
    }
}
