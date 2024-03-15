<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceArchiveRepository;
use App\Models\OccurrenceArchive;
use App\Validators\OccurrenceArchiveValidator;

/**
 * Class OccurrenceArchiveRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceArchiveRepositoryEloquent extends BaseRepository implements OccurrenceArchiveRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceArchive::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
