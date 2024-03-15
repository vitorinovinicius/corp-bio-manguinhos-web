<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\LogImportRepository;
use App\Models\LogImport;
use App\Validators\LogImportValidator;

/**
 * Class LogImportRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LogImportRepositoryEloquent extends BaseRepository implements LogImportRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LogImport::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
