<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\formularioRepository;
use App\Models\Formulario;
use App\Validators\FormularioValidator;

/**
 * Class FormularioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FormularioRepositoryEloquent extends BaseRepository implements FormularioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Formulario::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
