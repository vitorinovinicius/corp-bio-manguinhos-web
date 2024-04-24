<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FormularioImagemRepository;
use App\Models\FormularioImagem;
use App\Validators\FormularioImagemValidator;

/**
 * Class FormularioImagemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FormularioImagemRepositoryEloquent extends BaseRepository implements FormularioImagemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormularioImagem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
