<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceClientUserRepository;
use App\Models\OccurrenceClientUser;
use App\Validators\OccurrenceClientUserValidator;

/**
 * Class OccurrenceClientUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceClientUserRepositoryEloquent extends BaseRepository implements OccurrenceClientUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceClientUser::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
