<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SecaoImagemRepository;
use App\Models\SecaoImagem;
use App\Validators\SecaoImagemValidator;

/**
 * Class SecaoImagemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SecaoImagemRepositoryEloquent extends BaseRepository implements SecaoImagemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SecaoImagem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
