<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceTypeSkillCriteria.
 *
 * @package namespace App\Criteria;
 */
class OccurrenceTypeSkillCriteria implements CriteriaInterface
{
    /**
     * @var null
     */
    private $occurrence_type_id;

    /**
     * OccurrenceTypeSkillCriteria constructor.
     * @param null $occurrence_type_id
     */
    public function __construct( $occurrence_type_id = null)
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
            ->selectRaw('skills.*');
      
        $occurrence_type_id = Request::get('occurrence_type_id');

        if((isset($occurrence_type_id) && !empty($occurrence_type_id)) || $this->occurrence_type_id != null){

            $new_occurrence_type_id = ($occurrence_type_id)? $occurrence_type_id : $this->occurrence_type_id;

            $model->whereDoesntHave('occurrence_types', function ($query) use ($new_occurrence_type_id)  {
                $query->where('occurrence_type_skills.occurrence_type_id', '=', $new_occurrence_type_id);
                $query->orWhere('occurrence_type_skills.skill_id', '=', 'skills.id');
            });
        }

        $model->orderBy("skills.id","desc")
            ->distinct('id');
        return $model;
    }
}
