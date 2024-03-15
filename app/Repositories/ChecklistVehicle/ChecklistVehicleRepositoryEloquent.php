<?php

namespace App\Repositories\ChecklistVehicle;

use App\Models\ChecklistVehicle;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class AdjustmentDataBasicRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChecklistVehicleRepositoryEloquent extends BaseRepository implements ChecklistVehicleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ChecklistVehicle::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
