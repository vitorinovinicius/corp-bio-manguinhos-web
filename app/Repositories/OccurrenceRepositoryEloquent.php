<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceRepository;
use App\Models\Occurrence;
use App\Validators\OccurrenceValidator;

/**
 * Class OccurrenceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceRepositoryEloquent extends BaseRepository implements OccurrenceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Occurrence::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
