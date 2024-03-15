<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserZonesRemoveCriteria.
 *
 * @package namespace App\Criteria;
 */
class UserZonesRemoveCriteria implements CriteriaInterface
{

    private $user_id;

    /**
     * OccurrenceTypeSkillRemoveCriteria constructor.
     * @param $user_id
     */
    public function __construct($user_id)
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
            ->selectRaw('zones.*')
            ->join('user_zone', 'zones.id', '=', 'user_zone.zone_id');


        $id = \Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('zones.id', $id);
        }

        $name = \Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('zones.name', 'LIKE', $name . '%');
        }

        if ($this->user_id) {
            $model->where('user_zone.user_id', '=', $this->user_id);
        }

        return $model;
    }
}
