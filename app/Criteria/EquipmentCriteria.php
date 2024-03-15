<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;
/**
 * Class EquipmentCriteria.
 *
 * @package namespace App\Criteria;
 */
class EquipmentCriteria implements CriteriaInterface
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
//        $model = $model->with(['user']);

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

        $validate = Request::get('validate');
        if (isset($validate) && !empty($validate)) {
            $model->where('equipments.validate', 'LIKE','%'.$validate.'%');
        }

        $status = Request::get('status');
        if (isset($status) && !empty($status)) {
            $model->where('equipments.status', '=', $status);
        }

        return $model;
    }
}
