<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserZonesCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserZonesCriteria implements CriteriaInterface
{
     /**
     * OccurrenceTypeSkillCriteria constructor.
     * @param null $user_id
     */
    public function __construct( $user_id = null)
    {
        $this->user_id = $user_id;
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
            ->selectRaw('zones.*');


        $user_id = \Request::get('user_id');

        if((isset($user_id) && !empty($user_id)) || $this->user_id != null){

            $new_user_id = ($user_id)? $user_id : $this->user_id;

            $model->whereDoesntHave('users', function ($query) use ($new_user_id)  {
                $query->where('user_zone.user_id', '=', $new_user_id);
                $query->orWhere('user_zone.zone_id', '=', 'zones.id');
            });
        }

        $model->orderBy("zones.id","desc")
            ->distinct('id');
        return $model;
    }
}
