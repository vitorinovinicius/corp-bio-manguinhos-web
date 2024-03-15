<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserSkillRepository;
use App\Models\UserSkill;
use App\Validators\UserSkillValidator;

/**
 * Class UserSkillRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserSkillRepositoryEloquent extends BaseRepository implements UserSkillRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserSkill::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
