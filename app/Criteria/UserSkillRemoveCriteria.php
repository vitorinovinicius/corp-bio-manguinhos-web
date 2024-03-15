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
class UserSkillRemoveCriteria implements CriteriaInterface
{
    private $user_id;

    /**
     * OccurrenceTypeSkillRemoveCriteria constructor.
     * @param $user_id
     */
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
        $model = $model
            ->selectRaw('skills.*')
            ->join('user_skills', 'skills.id', '=', 'user_skills.skill_id');


        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('skills.id', $id);
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('skills.name', 'LIKE', $name . '%');
        }

        if ($this->user_id) {
            $model->where('user_skills.user_id', '=', $this->user_id);
        }

        return $model;
    }
}
