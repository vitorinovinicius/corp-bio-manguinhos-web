<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MoveRepository;
use App\Models\Move;
use App\Validators\MoveValidator;

/**
 * Class MoveRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MoveRepositoryEloquent extends BaseRepository implements MoveRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Move::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
