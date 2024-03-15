<?php

    namespace App\Criteria;

    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;
    use Carbon\Carbon;

    /**
     * Class RepaymentPdfCriteria.
     *
     * @package namespace App\Criteria;
     */
    class RepaymentPdfCriteria implements CriteriaInterface
    {
        private $contractor_id;
        private $user_id;
        private $dateIn;
        private $dateFn;

        public function __construct($contractor_id, $user_id, $dateIn, $dateFn)
        {
            $this->contractor_id = $contractor_id;
            $this->user_id = $user_id;
            $this->dateIn = $dateIn;
            $this->dateFn = $dateFn;
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

            $model = $model->selectRaw('expenses.*');

            if($this->contractor_id){
                $model->where('expenses.contractor_id', '=', $this->contractor_id);
            }

            if($this->user_id){
            $model->where('expenses.user_id', '=', $this->user_id);
            }

            if ($this->dateIn && $this->dateFn) {
                $dataIni = Carbon::createFromFormat('d-m-Y', $this->dateIn)->format('Y-m-d');
                $dataFim = Carbon::createFromFormat('d-m-Y', $this->dateFn)->format('Y-m-d');

                $model->whereBetween('date', [
                    $dataIni,
                    $dataFim
                ]);
            }

            $model->orderBy('date');

            return $model;
        }
    }
