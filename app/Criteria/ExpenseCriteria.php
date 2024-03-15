<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Request;

/**
 * Class RepaymentCriteria.
 *
 * @package namespace App\Criteria;
 */
class ExpenseCriteria implements CriteriaInterface
{
    private $user;
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
        $model = $model->selectRaw('expenses.*');

        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('expenses.id', '=', $id );
        }

        $contractor_id = Request::get('contractor_id');
        if (isset($contractor_id) && !empty($contractor_id)) {
            $model->where('expenses.contractor_id', '=', $contractor_id );
        }

        $operator_id = Request::get('operator_id');
        if (isset($operator_id) && !empty($operator_id)) {
            if ($operator_id == "x") {
                $model->where('expenses.user_id', '=', null);
            } else {
                $model->where('expenses.user_id', '=', $operator_id);
            }
        }

        $status = Request::get('status');
        if (isset($status) && !empty($status)) {
            $model->where('expenses.status', '=', $status );
        }

        $scheduled_date = Request::get('scheduled_date');
        if (isset($scheduled_date) && !empty($scheduled_date)) {
            $explodData = explode("-", $scheduled_date);
            $explodDataIni = explode("/", trim($explodData[0]));
            $explodDataFim = explode("/", trim($explodData[1]));


            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

            $model->whereBetween('date', [$dataIni, $dataFim]);

        }else{

            $curDate = Carbon::now()->format('Y-m-d');
            $diffDate = Carbon::now()->subMonth()->format('Y-m-d');

            $model->whereBetween('date', [$diffDate, $curDate]);
        }
       

        $model->orderBy("id", "desc");
        return $model;
    }
}
