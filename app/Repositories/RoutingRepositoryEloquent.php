<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutingRepository;
use App\Models\Routing;
use App\Validators\RoutingValidator;

/**
 * Class RoutingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutingRepositoryEloquent extends BaseRepository implements RoutingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Routing::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
