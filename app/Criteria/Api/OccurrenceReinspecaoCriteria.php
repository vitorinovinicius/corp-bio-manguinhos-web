<?php

namespace App\Criteria\Api;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceReinspecaoCriteria
 * @package namespace Vanzolini\Criteria\Api;
 */
class OccurrenceReinspecaoCriteria implements CriteriaInterface
{
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
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
        $model = $model
            ->with(['occurrence_types','occurrence_clients'])
//            ->selectRaw('occurrences.*')
            ->where('operator_id',$this->user_id)
            ->where('open_close', true)
            ->where('schedule_date', Carbon::today())
            ->where('os_before','<>','')
            ->where('os_before','<>',null)
            ->orderBy('priority','desc');


        return $model;
    }
}
