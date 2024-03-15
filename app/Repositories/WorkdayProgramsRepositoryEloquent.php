<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WorkdayProgramsRepository;
use App\Models\WorkdayPrograms;
use App\Validators\WorkdayProgramsValidator;

/**
 * Class WorkdayProgramsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WorkdayProgramsRepositoryEloquent extends BaseRepository implements WorkdayProgramsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkdayPrograms::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
