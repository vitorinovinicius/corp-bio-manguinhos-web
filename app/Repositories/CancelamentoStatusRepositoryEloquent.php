<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CancelamentoStatusRepository;
use App\Models\CancelamentoStatus;
use App\Validators\CancelamentoStatusValidator;

/**
 * Class CancelamentoStatusRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CancelamentoStatusRepositoryEloquent extends BaseRepository implements CancelamentoStatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CancelamentoStatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
