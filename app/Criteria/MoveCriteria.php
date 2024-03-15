<?php

    namespace App\Criteria;

    use Carbon\Carbon;
    use Illuminate\Support\Facades\Request;
    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;

    /**
     * Class MoveCriteria.
     *
     * @package namespace App\Criteria;
     */
    class MoveCriteria implements CriteriaInterface
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
            $model = $model
//                ->with('operator')
                ->selectRaw('moves.*')
                ->join('users', 'moves.operator_id', '=', 'users.id')
                ->whereIn('moves.move_type_id', [1, 2, 3, 8]);

            $periodo = Request::get('periodo');
            if (isset($periodo) && !empty($periodo)) {
                $periodo = format_range_to_database($periodo);
                $model->whereBetween('moves.check_in', [$periodo[0], $periodo[1]]);
            } else {
                $model->where('moves.check_in', Carbon::now()->format("Y-m-d"));
            }

            $contractor = Request::get('contractor_id');
            if (isset($contractor) && !empty($contractor)) {
                $model->where('users.contractor_id', '=', $contractor);
            }

            $tecnico = Request::get('name');
            if (isset($tecnico) && !empty($tecnico)) {
                $model->where('users.name', 'LIKE', '%' . $tecnico . '%');
            }

            $operator_id = Request::get('operator_id');
            if (isset($operator_id) && !empty($operator_id)) {
                $model->where('moves.operator_id', '=', $operator_id);
            }

            $move_type_id = Request::get('move_type_id');
            if (isset($move_type_id) && !empty($move_type_id)) {
                $model->where('moves.move_type_id', '=', $move_type_id);
            }

            $model->orderBy("id", "DESC");
            $model->orderBy("operator_id", "ASC");
            $model->orderBy("move_type_id", "DESC");

            return $model;
        }
    }
