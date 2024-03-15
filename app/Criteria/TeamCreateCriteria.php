<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class TeamCreateCriteria.
 *
 * @package namespace App\Criteria;
 */
class TeamCreateCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->selectRaw('users.*');
        $model = $model->join('role_user', 'users.id', '=' ,'role_user.user_id');

        $model->where('role_user.role_id','=',3);

        return $model;
    }
}
