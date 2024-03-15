<?php

    namespace App\Criteria;

    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;

    /**
     * Class OccurrenceInterferenceCriteria.
     *
     * @package namespace App\Criteria;
     */
    class OccurrenceInterferenceCriteria implements CriteriaInterface
    {
        private $interference;

        /**
         * OccurrenceInterferenceCriteria constructor.
         * @param $interference
         */
        public function __construct($interference)
        {
            $this->interference = $interference;
        }

        /**
         * Apply criteria in query repository
         *
         * @param string $model
         * @param RepositoryInterface $repository
         *
         * @return mixed
         */


        public function apply($model, RepositoryInterface $repository)
        {
            $interference = $this->interference;

            $model = $model->selectRaw('occurrences.*');

            if (\Auth::user()->contractor_id) {
                $model = $model->where('occurrences.contractor_id', \Auth::user()->contractor_id);
            }

            $model->whereHas('interferences', function ($query) {
                $query->where('occurrence_interference.interference_id', '=', $this->interference->id);
            });

            //Pega os filtros
            criteriaSearch($model);

            $model->orderBy("occurrences.schedule_date", "DESC");
            $model->orderBy("occurrences.priority", "DESC");
            $model->orderBy("occurrences.id", "DESC");

            return $model;
        }
    }
