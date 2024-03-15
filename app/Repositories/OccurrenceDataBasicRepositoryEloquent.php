<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceDataBasicRepository;
use App\Models\OccurrenceDataBasic;
use App\Validators\OccurrenceDataBasicValidator;

/**
 * Class OccurrenceDataBasicRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceDataBasicRepositoryEloquent extends BaseRepository implements OccurrenceDataBasicRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceDataBasic::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
