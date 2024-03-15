<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FinancialCommunicationRepository;
use App\Models\FinancialCommunication;
use App\Validators\FinancialCommunicationValidator;

/**
 * Class FinancialCommunicationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FinancialCommunicationRepositoryEloquent extends BaseRepository implements FinancialCommunicationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FinancialCommunication::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
