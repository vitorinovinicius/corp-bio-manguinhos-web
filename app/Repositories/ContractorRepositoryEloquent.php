<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContractorRepository;
use App\Models\Contractor;
use App\Validators\ContractorValidator;

/**
 * Class ContractorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContractorRepositoryEloquent extends BaseRepository implements ContractorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contractor::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
