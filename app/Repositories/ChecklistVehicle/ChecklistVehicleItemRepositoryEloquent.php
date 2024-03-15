<?php

namespace App\Repositories\ChecklistVehicle;

use App\Models\ChecklistVehicleBasic;
use App\Models\ChecklistVehicleIten;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class AdjustmentDataBasicRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChecklistVehicleItemRepositoryEloquent extends BaseRepository implements ChecklistVehicleItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ChecklistVehicleIten::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
