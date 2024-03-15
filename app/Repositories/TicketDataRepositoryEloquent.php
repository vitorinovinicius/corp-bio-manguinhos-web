<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketDataRepository;
use App\Models\TicketData;
use App\Validators\TicketDataValidator;

/**
 * Class TicketDataRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketDataRepositoryEloquent extends BaseRepository implements TicketDataRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketData::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
