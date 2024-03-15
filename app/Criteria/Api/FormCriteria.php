<?php

namespace App\Criteria\Api;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceTypeCriteriaCriteria.
 *
 * @package namespace App\Criteria\Api;
 */
class FormCriteria implements CriteriaInterface
{
    private $uuids;

    /**
     * OccurrenceTypeCriteriaCriteria constructor.
     * @param $uuids
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

        $model = $model->with(['form_groups','form_groups.form_sections','form_groups.form_sections.form_fields']);

//        $model = $model->where('type_in',2); //IN78
        if (\Auth::user()->contractor_id) {
            $model = $model->where("contractor_id","=", \Auth::user()->contractor_id);
        }
        if(!empty($this->uuids)){
            $model = $model->whereNotIn("uuid", $this->uuids);
        }

        return $model;
    }
}
