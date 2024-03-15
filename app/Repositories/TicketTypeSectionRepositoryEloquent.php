<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketTypeSectionRepository;
use App\Models\TicketTypeSection;
use App\Validators\TicketTypeSectionValidator;

/**
 * Class TicketTypeSectionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketTypeSectionRepositoryEloquent extends BaseRepository implements TicketTypeSectionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketTypeSection::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
