<?php

namespace App\Criteria\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceOrderCriteria
 * @package namespace Bureau\Criteria;
 */
class OccurrencePendingOrderCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $operator_id;

    /**
     * OccurrenceOrderCriteria constructor.
     */
    public function __construct($operator_id)
    {
        $this->operator_id = $operator_id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixedx
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model
            ->with(['occurrence_type', 'occurrence_client', 'occurrence_data_basic'])
            ->selectRaw('occurrences.*')
            ->where([
                "occurrences.operator_id" => $this->operator_id,
                "occurrences.status" => 1,
                "occurrences.download_at" => null,
            ]);


        $model->where('occurrences.schedule_date','>=', Carbon::today());
        //$model->orderBy('occurrences.schedule_date', 'ASC');
        $model->orderBy('occurrences.order_client', 'ASC');

        return $model;
    }
}
