<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OccurrencePdfRepository;
use App\Models\OccurrencePdf;
use App\Validators\OccurrencePdfValidator;

/**
 * Class OccurrencePdfRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrencePdfRepositoryEloquent extends BaseRepository implements OccurrencePdfRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrencePdf::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
