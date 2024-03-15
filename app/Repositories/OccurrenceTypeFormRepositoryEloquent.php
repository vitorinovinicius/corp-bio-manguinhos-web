<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceTypeFormRepository;
use App\Models\OccurrenceTypeForm;
use App\Validators\OccurrenceTypeFormValidator;

/**
 * Class OccurrenceTypeFormRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceTypeFormRepositoryEloquent extends BaseRepository implements OccurrenceTypeFormRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceTypeForm::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
