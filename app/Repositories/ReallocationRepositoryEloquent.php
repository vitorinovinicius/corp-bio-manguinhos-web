<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ReallocationRepository;
use App\Models\Reallocation;
use App\Validators\ReallocationValidator;

/**
 * Class ReallocationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReallocationRepositoryEloquent extends BaseRepository implements ReallocationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Reallocation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
