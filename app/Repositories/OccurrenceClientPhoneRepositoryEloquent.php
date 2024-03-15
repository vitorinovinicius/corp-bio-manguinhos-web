<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrenceClientPhoneRepository;
use App\Models\OccurrenceClientPhone;
use App\Validators\OccurrenceClientPhoneValidator;

/**
 * Class OccurrenceClientPhoneRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceClientPhoneRepositoryEloquent extends BaseRepository implements OccurrenceClientPhoneRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceClientPhone::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
