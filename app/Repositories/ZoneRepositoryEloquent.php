<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ZoneRepository;
use App\Models\Zone;
use App\Validators\ZoneValidator;

/**
 * Class ZoneRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ZoneRepositoryEloquent extends BaseRepository implements ZoneRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Zone::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
