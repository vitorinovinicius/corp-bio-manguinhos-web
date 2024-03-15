<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ExpenseTypesRepository;
use App\Models\ExpenseTypes;
use App\Validators\ExpenseTypesValidator;

/**
 * Class ExpenseTypesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ExpenseTypesRepositoryEloquent extends BaseRepository implements ExpenseTypesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ExpenseTypes::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
