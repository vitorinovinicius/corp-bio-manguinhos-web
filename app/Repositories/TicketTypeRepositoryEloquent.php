<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketTypeRepository;
use App\Models\TicketType;
use App\Validators\TicketTypeValidator;

/**
 * Class TicketTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketTypeRepositoryEloquent extends BaseRepository implements TicketTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
