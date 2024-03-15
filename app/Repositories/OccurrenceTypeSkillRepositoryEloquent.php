<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceTypeSkillRepository;
use App\Models\OccurrenceTypeSkill;
use App\Validators\OccurrenceSkillValidator;

/**
 * Class OccurrenceTypeSkillRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceTypeSkillRepositoryEloquent extends BaseRepository implements OccurrenceTypeSkillRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceTypeSkill::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
