<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LogImportErrorRepository;
use App\Models\LogImportError;
use App\Validators\LogImportErrorValidator;

/**
 * Class LogImportErrorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LogImportErrorRepositoryEloquent extends BaseRepository implements LogImportErrorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LogImportError::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
