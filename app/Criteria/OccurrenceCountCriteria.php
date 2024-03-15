<?php

namespace App\Criteria;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceCountCriteria
 * @package namespace App\Criteria;
 */
class OccurrenceCountCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $id_tipo;

    /**
     * OccurrenceCountCriteria constructor.
     */
    public function __construct($id_tipo)
    {
        $this->id_tipo = $id_tipo;
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


        if ($this->id_tipo == "1") {
            //Não atribuídos
            return $model->select(DB::raw('count(id) as occurrence_count'))
                ->where(["status" => 1, "operator_id" => null]);
        } elseif ($this->id_tipo == "2") {
            //Pendente
            return $model->select(DB::raw('count(id) as occurrence_count'))
                ->where(["status" => 1])
                ->where("operator_id", "<>", null)
                ->where("operator_id", "<>", "");
        } elseif ($this->id_tipo == "3") {
            //Realizados
            return $model->select(DB::raw('count(id) as occurrence_count'))
                ->where("status", "=", 2)//Fechado
                ->where("operator_id", "<>", null)//pertence a um operador
                ->where("operator_id", "<>", ""); //pertence a um operador
        } elseif ($this->id_tipo == "4") {
            //Náo realizados
            return $model->select(DB::raw('count(id) as occurrence_count'))
                ->where("status", "=", 3)//Fechado
                ->where("operator_id", "<>", null)//pertence a um operador
                ->where("operator_id", "<>", ""); //pertence a um operador
        } else {
            return $model->select(DB::raw('count(id) as occurrence_count'));
        }
    }
}
