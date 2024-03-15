<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceTypeFormSearchCriteria.
 *
 * @package namespace App\Criteria;
 */
class OccurrenceTypeFormSearchCriteria implements CriteriaInterface
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

        $occurrence_type_id = Request::get('occurrence_type_id');
        if(isset($occurrence_type_id) && !empty($occurrence_type_id)){
            $model = $model->where('occurrence_type_id', '=', $occurrence_type_id);
        }

        $form_id = Request::get('form_id');
        if(isset($form_id) && !empty($form_id)){
            $model = $model->where('form_id', '=', $form_id);
        }

        return $model;

    }
}
