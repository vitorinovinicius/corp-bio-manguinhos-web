<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Request;

/**
 * Class ChecklistVehicleItemCriteria.
 *
 * @package namespace App\Criteria;
 */
class ChecklistVehicleItemCriteria implements CriteriaInterface
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
        $model = $model ->selectRaw('checklist_vehicle_itens.*');

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('checklist_vehicle_itens.id', '=', $id );
        }

        $descricao = Request::get('descricao');
        if (isset($descricao) && !empty($descricao)) {
            $model->where('checklist_vehicle_itens.descricao', '=' , $descricao);
        }

        $typeId = Request::get('type_id');
        if (isset($typeId) && !empty($typeId)) {
            $model->where('checklist_vehicle_itens.type_id', '=' , $typeId);
        }
       

        return $model;
    }
}
