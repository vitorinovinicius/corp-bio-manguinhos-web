<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FinishWorkDayRepository;
use App\Models\FinishWorkDay;
use App\Validators\FinishWorkDayValidator;

/**
 * Class FinishWorkDayRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FinishWorkDayRepositoryEloquent extends BaseRepository implements FinishWorkDayRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FinishWorkDay::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
