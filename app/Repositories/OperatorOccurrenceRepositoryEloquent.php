<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperatorOccurrenceRepository;
use App\Models\OperatorOccurrence;
use App\Validators\OperatorOccurrenceValidator;

/**
 * Class OperatorOccurrenceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperatorOccurrenceRepositoryEloquent extends BaseRepository implements OperatorOccurrenceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperatorOccurrence::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
