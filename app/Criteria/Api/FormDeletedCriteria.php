<?php

namespace App\Criteria\Api;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FormDeletedCriteria.
 *
 * @package namespace App\Criteria\Mobile;
 */
class FormDeletedCriteria implements CriteriaInterface
{
    private $uuids;

    /**
     * FormDeletedCriteria constructor.
     */
    public function __construct($uuids)
    {
        $this->uuids = $uuids;
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

        $user = \Auth::guard('api')->user();

        $model = $model->with([
            'form_sections',
            'form_sections.form_fields'
        ]);

        $model->whereIn("uuid",$this->uuids);

        $model->where("contractor_id", $user->contractor_id);

        $model->onlyTrashed();

        return $model;
    }
}
