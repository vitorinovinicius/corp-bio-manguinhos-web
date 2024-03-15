<?php

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AlertSelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class AlertSelectCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('alerts.*');

        if (request()->get('created_at')) {
            $scheduled_date = format_range_to_database(request()->get('created_at'));
            $model->whereBetween('created_at', [$scheduled_date[0], $scheduled_date[1]]);
        }else{
            $model->where('created_at', 'like', Carbon::Today()->toDateString() . "%");
        }

        if (request()->get('type')) {
            $model->where('type',request()->get('type'));
        }

//            $model->where('created_at', 'like', Carbon::parse(request()->get('created_at')) . "%");

        $model->orderBy("id","desc");
        return $model;
    }
}
