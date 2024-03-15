<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UsersSelectCriteria
 * @package namespace App\Criteria;
 */
class UsersSelectCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {

        $model = $model->selectRaw('users.*')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', "!=", 4);



        $model->orderBy("id", "desc");
        $model->distinct();
        return $model;
    }
}
