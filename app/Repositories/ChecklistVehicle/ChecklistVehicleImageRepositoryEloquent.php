<?php

namespace App\Repositories\ChecklistVehicle;

use App\Models\ChecklistVehicleBasic;
use App\Models\ChecklistVehicleImage;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class AdjustmentDataBasicRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ChecklistVehicleImageRepositoryEloquent extends BaseRepository implements ChecklistVehicleImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ChecklistVehicleImage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
