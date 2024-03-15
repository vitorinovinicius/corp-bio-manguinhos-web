<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\GeneralSettingRepository;
use App\Models\GeneralSetting;
use App\Validators\GeneralSettingValidator;

/**
 * Class GeneralSettingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class GeneralSettingRepositoryEloquent extends BaseRepository implements GeneralSettingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GeneralSetting::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
