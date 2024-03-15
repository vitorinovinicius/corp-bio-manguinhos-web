<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FormSectionRepository;
use App\Models\FormSection;
use App\Validators\FormSectionValidator;

/**
 * Class FormSectionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FormSectionRepositoryEloquent extends BaseRepository implements FormSectionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormSection::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
