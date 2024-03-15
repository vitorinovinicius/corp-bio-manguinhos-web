<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PlanOccurrencesRepository;
use App\Models\PlanOccurrence;
use App\Validators\PlanOccurrencesValidator;

/**
 * Class PlanOccurrencesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PlanOccurrenceRepositoryEloquent extends BaseRepository implements PlanOccurrenceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanOccurrence::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
