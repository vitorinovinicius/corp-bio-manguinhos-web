<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SetorRepository;
use App\Models\Setor;
use App\Validators\SetorValidator;

/**
 * Class SetorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SetorRepositoryEloquent extends BaseRepository implements SetorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Setor::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
