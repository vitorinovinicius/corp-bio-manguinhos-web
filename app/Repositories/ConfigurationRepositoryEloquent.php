<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConfigurationRepository;
use App\Models\Configuration;
use App\Validators\ConfigurationValidator;

/**
 * Class ConfigurationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConfigurationRepositoryEloquent extends BaseRepository implements ConfigurationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Configuration::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
