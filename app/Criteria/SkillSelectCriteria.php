<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Request;

/**
 * Class SkillSelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class SkillSelectCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('skills.*');

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('skills.id', '=', $id );
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('skills.name', 'LIKE','%'.$name.'%');
        }

        $description = Request::get('description');
        if (isset($description) && !empty($descriptiondescription)) {
            $model->where('skills.description', 'LIKE','%'.$name.'%');
        }

        return $model;
    }
}
