<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FormFieldRepository;
use App\Models\FormField;
use App\Validators\FormFieldValidator;

/**
 * Class FormFieldRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FormFieldRepositoryEloquent extends BaseRepository implements FormFieldRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormField::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
