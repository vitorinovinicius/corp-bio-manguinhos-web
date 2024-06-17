<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SecaoFormularioRepository;
use App\Models\SecaoFormulario;
use App\Validators\SecaoFormularioValidator;

/**
 * Class SecaoFormularioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SecaoFormularioRepositoryEloquent extends BaseRepository implements SecaoFormularioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SecaoFormulario::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
