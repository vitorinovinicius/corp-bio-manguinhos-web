<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MoveTypeRepository;
use App\Models\MoveType;
use App\Validators\MoveTypeValidator;

/**
 * Class MoveTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MoveTypeRepositoryEloquent extends BaseRepository implements MoveTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MoveType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
