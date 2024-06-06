<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RelatorioRepository;
use App\Models\Relatorio;
use App\Validators\RelatorioValidator;

/**
 * Class RelatorioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RelatorioRepositoryEloquent extends BaseRepository implements RelatorioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Relatorio::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
