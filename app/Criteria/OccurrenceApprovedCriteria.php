<?php

    namespace App\Criteria;

    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Request;
    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;

    /**
     * Class OccurrenceClosedCriteria
     * @package namespace App\Criteria;
     */
    class OccurrenceApprovedCriteria implements CriteriaInterface
    {
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
            //        $model = $model->selectRaw('occurrences.*, SUM(uniao.valor_total) AS soma');
            $model = $model->selectRaw('occurrences.*');

            $model = $model->where("occurrences.status", "=", 2); // realizado

            $model = $model->where("occurrences.approved", "=", 1); // liberadas

        //Pega os filtros
        criteriaSearch($model);

            $model->groupBy('occurrences.id');

            //        $model->havingRaw('SUM(uniao.valor_total) > 500');

            $model->orderBy("occurrences.check_out", "DESC");

            return $model;
        }
    }
