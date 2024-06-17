<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EmailRepository;
use App\Models\Email;
use App\Validators\EmailValidator;

/**
 * Class EmailRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmailRepositoryEloquent extends BaseRepository implements EmailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Email::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
