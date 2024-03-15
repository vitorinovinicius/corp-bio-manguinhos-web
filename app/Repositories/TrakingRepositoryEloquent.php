<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TrakingRepository;
use App\Models\Traking;
use App\Validators\TrakingValidator;

/**
 * Class TrakingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TrakingRepositoryEloquent extends BaseRepository implements TrakingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Traking::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
