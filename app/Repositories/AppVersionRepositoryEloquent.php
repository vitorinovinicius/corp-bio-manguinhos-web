<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AppVersionRepository;
use App\Models\AppVersion;
use App\Validators\AppVersionValidator;

/**
 * Class AppVersionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AppVersionRepositoryEloquent extends BaseRepository implements AppVersionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AppVersion::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
