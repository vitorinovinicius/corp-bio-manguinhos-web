<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserSetoresRepository;
use App\Models\UserSetores;
use App\Validators\UserSetoresValidator;

/**
 * Class UserSetoresRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserSetoresRepositoryEloquent extends BaseRepository implements UserSetoresRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserSetores::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
