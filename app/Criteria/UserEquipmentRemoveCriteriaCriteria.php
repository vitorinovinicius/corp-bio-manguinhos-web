<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;

/**
 * Class UserEquipmentRemoveCriteriaCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserEquipmentRemoveCriteriaCriteria implements CriteriaInterface
{
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
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
        $model = $model->where("user_id", "=", $this->user_id);

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
