<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ArchiveRepository;
use App\Models\Archive;
use App\Validators\ArchiveValidator;

/**
 * Class ArchiveRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ArchiveRepositoryEloquent extends BaseRepository implements ArchiveRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Archive::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
