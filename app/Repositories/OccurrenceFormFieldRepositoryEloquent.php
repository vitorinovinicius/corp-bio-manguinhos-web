<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceFormFieldRepository;
use App\Models\OccurrenceFormField;
use App\Validators\OccurrenceFormFieldValidator;

/**
 * Class OccurrenceFormFieldRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceFormFieldRepositoryEloquent extends BaseRepository implements OccurrenceFormFieldRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceFormField::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
