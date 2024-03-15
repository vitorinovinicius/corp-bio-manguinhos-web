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
class OccurrenceOrderCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $tl;
    /**
     * @var
     */
    private $operator_id;
    /**
     * @var
     */
    private $force;

    /**
     * OccurrenceOrderCriteria constructor.
     */
    public function __construct($operator_id, $force)
    {
        $this->operator_id = $operator_id;
        $this->force = $force;
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
            ->selectRaw('occurrences.*'); // Não tirar

        $model->where('occurrences.operator_id', $this->operator_id);

        if ($this->force == false) {
            $model->where([
                "occurrences.status" => 1,
                "occurrences.download_at" => null,
            ]);
        } else {
            $model->where([
                "occurrences.status" => 1,
            ]);
        }

        $model->where('occurrences.schedule_date', Carbon::today());
        $model->orderBy("occurrences.shift", "ASC");
        $model->orderBy("occurrences.priority", "DESC");
        $model->orderBy('occurrences.order_client', 'ASC');
        $model->orderBy("occurrences.occurrence_type_id", "ASC");

        return $model;
    }
}
