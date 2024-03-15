<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceClientRepository;
use App\Models\OccurrenceClient;
use App\Validators\OccurrenceClientValidator;

/**
 * Class OccurrenceClientRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceClientRepositoryEloquent extends BaseRepository implements OccurrenceClientRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceClient::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
