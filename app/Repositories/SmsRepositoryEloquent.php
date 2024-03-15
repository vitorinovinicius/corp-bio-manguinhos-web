<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SmsRepository;
use App\Models\Sms;
use App\Validators\SmsValidator;

/**
 * Class SmsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SmsRepositoryEloquent extends BaseRepository implements SmsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sms::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
