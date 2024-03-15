<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceTypeRepository;
use App\Models\OccurrenceType;
use App\Validators\OccurrenceTypeValidator;

/**
 * Class OccurrenceTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceTypeRepositoryEloquent extends BaseRepository implements OccurrenceTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
