<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OperatorAjaxCriteria.
 *
 * @package namespace App\Criteria;
 */
class OperatorAjaxCriteria implements CriteriaInterface
{
    private $contractor_id;

    public function __construct($contractor_id)
    {
        $this->contractor_id = $contractor_id;    
    }
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
        $model = $model
            ->selectRaw('users.*')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('role_user.role_id', 4);

            $model->where('users.status', 1);
            $model->where('users.contractor_id', $this->contractor_id);
            
        return $model;
    }
}
