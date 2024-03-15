<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ArchivesRepository;
use App\Models\Archives;
use App\Validators\ArchivesValidator;

/**
 * Class ArchivesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ArchivesRepositoryEloquent extends BaseRepository implements ArchivesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Archives::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
