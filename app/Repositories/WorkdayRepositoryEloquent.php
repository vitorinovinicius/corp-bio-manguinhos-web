<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WorkdayRepository;
use App\Models\Workday;
use App\Validators\WorkdayValidator;

/**
 * Class WorkdayRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WorkdayRepositoryEloquent extends BaseRepository implements WorkdayRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Workday::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
