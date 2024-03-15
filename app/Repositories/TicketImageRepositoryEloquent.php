<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TicketImageRepository;
use App\Models\TicketImage;
use App\Validators\TicketImageValidator;

/**
 * Class TicketImageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TicketImageRepositoryEloquent extends BaseRepository implements TicketImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketImage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
