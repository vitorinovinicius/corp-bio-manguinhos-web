<?php

namespace App\Repositories;

use App\Models\Interference;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class TeamRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class InterferenceRepositoryEloquent extends BaseRepository implements InterferenceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Interference::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
