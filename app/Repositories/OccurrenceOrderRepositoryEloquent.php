<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceOrderRepository;
use App\Models\OccurrenceOrder;
use App\Validators\OccurrenceOrderValidator;

/**
 * Class OccurrenceOrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceOrderRepositoryEloquent extends BaseRepository implements OccurrenceOrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceOrder::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
