<?php

namespace App\Criteria\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ExpenseCriteria.
 *
 * @package namespace App\Criteria\Api;
 */
class ExpenseCriteria implements CriteriaInterface
{
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

        $user = \Auth::guard('api')->user();
        $model->where('expenses.user_id', '=', $user->id);


        $id = Request::get('id');
        if (isset($id) && !empty($id)) {
            $model->where('expenses.id', '=', $id );
        }

        $contractor_id = Request::get('contractor_id');
        if (isset($contractor_id) && !empty($contractor_id)) {
            $model->where('expenses.contractor_id', '=', $contractor_id );
        }

        $expense_types_id = Request::get('expense_types_id');
        if (isset($expense_types_id) && !empty($expense_types_id)) {
            $model->where('expenses.expense_types_id', '=', $expense_types_id );
        }

        $occurrence_id = Request::get('occurrence_id');
        if (isset($occurrence_id) && !empty($occurrence_id)) {
            $model->where('expenses.occurrence_id', '=', $occurrence_id );
        }

        $status = Request::get('status');
        if (isset($status) && !empty($status)) {
            $model->where('expenses.status', '=', $status );
        }

        $date = Request::get('date');
        if (isset($date) && !empty($date)) {
            $explodData = explode("-", $date);
            $explodDataIni = explode("/", trim($explodData[0]));
            $explodDataFim = explode("/", trim($explodData[1]));


            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

            $model->whereBetween('date', [$dataIni, $dataFim]);

        }else{
            $model->where('date', Carbon::today());
        }

        $model->orderBy('id','asc')->distinct();
        return $model;
    }
}
