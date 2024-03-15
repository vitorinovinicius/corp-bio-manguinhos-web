<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContractorDistrictRepository;
use App\Models\ContractorDistrict;
use App\Validators\ContractorDistrictValidator;

/**
 * Class ContractorDistrictRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContractorDistrictRepositoryEloquent extends BaseRepository implements ContractorDistrictRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContractorDistrict::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
