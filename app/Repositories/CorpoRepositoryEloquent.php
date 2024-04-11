<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CorpoRepository;
use App\Models\Corpo;
use App\Validators\CorpoValidator;

/**
 * Class CorpoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CorpoRepositoryEloquent extends BaseRepository implements CorpoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Corpo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
