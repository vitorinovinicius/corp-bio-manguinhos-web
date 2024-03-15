<?php

    namespace App\Criteria;

    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;
    use Illuminate\Support\Facades\Request;
    use Carbon\Carbon;

    /**
     * Class RepaymentCriteria.
     *
     * @package namespace App\Criteria;
     */
    class RepaymentCriteria implements CriteriaInterface
    {
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

            $contractor_id = Request::get('contractor_id');
            if (isset($contractor_id) && !empty($contractor_id)) {
                $model->where('expenses.contractor_id', '=', $contractor_id);
            } 

            $user_id = Request::get('user_id');
            if ($user_id) {
                $model->where('expenses.user_id', '=', $user_id);
            }

            $scheduled_date = Request::get('scheduled_date');
            if (isset($scheduled_date) && !empty($scheduled_date)) {
                $explodData = explode("-", $scheduled_date);
                $explodDataIni = explode("/", trim($explodData[0]));
                $explodDataFim = explode("/", trim($explodData[1]));


                $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
                $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

                $model->whereBetween('date', [
                    $dataIni,
                    $dataFim
                ]);

            } else {

                $curDate = Carbon::now()->format('Y-m-d');
                $diffDate = Carbon::now()->subMonth()->format('Y-m-d');

                $model->whereBetween('date', [
                    $diffDate,
                    $curDate
                ]);
            }

            $model->orderBy('date');

            return $model;
        }
    }
