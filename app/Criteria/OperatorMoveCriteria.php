<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OperatorMoveCriteria.
 *
 * @package namespace App\Criteria;
 */
class OperatorMoveCriteria implements CriteriaInterface
{
    private $operator_id;
    private $dataTracking;
    /**
     * @var bool
     */
    private $between;

    /**
     * OperatorMoveCriteria constructor.
     * @param $operator_id
     * @param $dataTracking
     * @param bool $between
     */
    public function __construct($operator_id, $dataTracking, $between=false)
    {
        $this->operator_id = $operator_id;
        $this->dataTracking = $dataTracking;
        $this->between = $between;
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

        if($this->between){
            $explodData = explode("-", $this->dataTracking);
            $explodDataIni = explode("/", trim($explodData[0]));
            $explodDataFim = explode("/", trim($explodData[1]));
            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0] . " 00:00:00";
            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0] . " 23:59:59";

            $model = $model->where("operator_id", "=", $this->operator_id)
                ->whereBetween('check_in', [$dataIni,$dataFim])
                ->orderBy('check_in', 'asc');
        }else{
            $model = $model->where("operator_id", "=", $this->operator_id)
            ->where("check_in", ">=", $this->dataTracking)
            ->orderBy('check_in', 'asc');
        }

        return $model;
    }
}
