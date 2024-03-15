<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceDataClientRepository;
use App\Models\OccurrenceDataClient;
use App\Validators\OccurrenceDataClientValidator;

/**
 * Class OccurrenceDataClientRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceDataClientRepositoryEloquent extends BaseRepository implements OccurrenceDataClientRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceDataClient::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
