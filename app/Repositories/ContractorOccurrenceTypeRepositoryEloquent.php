<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContractorOccurrenceTypeRepository;
use App\Models\ContractorOccurrenceType;
use App\Validators\ContractorOccurrenceTypeValidator;

/**
 * Class ContractorOccurrenceTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ContractorOccurrenceTypeRepositoryEloquent extends BaseRepository implements ContractorOccurrenceTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContractorOccurrenceType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
