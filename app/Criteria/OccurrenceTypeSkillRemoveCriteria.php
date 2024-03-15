<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceTypeSkillRemoveCriteria.
 *
 * @package namespace App\Criteria;
 */
class OccurrenceTypeSkillRemoveCriteria implements CriteriaInterface
{
    private $occurrence_type_id;

    /**
     * OccurrenceTypeSkillRemoveCriteria constructor.
     * @param $occurrence_type_id
     */
    public function __construct($occurrence_type_id)
    {
        $this->occurrence_type_id = $occurrence_type_id;
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
        $model = $model
            ->selectRaw('skills.*')
            ->join('occurrence_type_skills', 'skills.id', '=', 'occurrence_type_skills.skill_id');


        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('skills.id', $id);
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('skills.name', 'LIKE', $name . '%');
        }

        if ($this->occurrence_type_id) {
            $model->where('occurrence_type_skills.occurrence_type_id', '=', $this->occurrence_type_id);
        }

        return $model;
    }
}
