<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ExecutionRepository;
use App\Models\Execution;
use App\Validators\ExecutionValidator;

/**
 * Class ExecutionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ExecutionRepositoryEloquent extends BaseRepository implements ExecutionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Execution::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
