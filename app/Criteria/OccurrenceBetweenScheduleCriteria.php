<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon\Carbon;

/**
 * Class OccurrenceBetweenSchedudeCriteriaCriteria.
 *
 * @package namespace App\Criteria;
 */
class OccurrenceBetweenScheduleCriteria implements CriteriaInterface
{
    private $operator;
    private $scheduleI;
    private $scheduleF;

    public function __construct($operator, $scheduleI, $scheduleF)
    {
        $this->operator = $operator;
        $this->scheduleI = $scheduleI;
        $this->scheduleF = $scheduleF;
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
        $model = $model->selectRaw('occurrences.*');

        if (!empty($this->scheduleI) || !empty($this->schedulef)) {
            $model->whereBetween('schedule_date', [$this->scheduleI, $this->scheduleF]);
        } else {
            $model->where('schedule_date', '>=',  Carbon::now()->format('Y-m-d'));
        }
        
        $model->where('status', 2); //Somente occurrences realizadas


        return $model;
    }
}
