<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FormGroupRepository;
use App\Models\FormGroup;
use App\Validators\FormGroupValidator;

/**
 * Class FormGroupRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FormGroupRepositoryEloquent extends BaseRepository implements FormGroupRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormGroup::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
