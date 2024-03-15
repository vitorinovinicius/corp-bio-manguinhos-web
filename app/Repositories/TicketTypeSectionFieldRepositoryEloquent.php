<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketTypeSectionFieldRepository;
use App\Models\TicketTypeSectionField;
use App\Validators\TicketTypeSectionFieldValidator;

/**
 * Class TicketTypeSectionFieldRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketTypeSectionFieldRepositoryEloquent extends BaseRepository implements TicketTypeSectionFieldRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketTypeSectionField::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
