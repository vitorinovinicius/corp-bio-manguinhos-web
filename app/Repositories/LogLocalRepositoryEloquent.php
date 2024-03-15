<?php

namespace App\Repositories;

use App\Models\LogLocal;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DocumentRepository;
use App\Models\Document;

/**
 * Class DocumentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class LogLocalRepositoryEloquent extends BaseRepository implements LogLocalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LogLocal::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
