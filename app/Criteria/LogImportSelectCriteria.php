<?php

namespace App\Criteria;

use Artesaos\Defender\Facades\Defender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OccurrenceSelectCriteria
 * @package namespace App\Criteria;
 */
class LogImportSelectCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('type_import',1);

        $contractor_id = Request::get('contractor_id');
        if (isset($contractor_id) && !empty($contractor_id) && is_numeric($contractor_id)) {
            $model->where('log_imports.contractor_id', '=', $contractor_id);
        }

        $user_id = Request::get('user_id');
        if (isset($user_id) && !empty($user_id) && is_numeric($user_id)) {
            $model->where('log_imports.user_id', '=', $user_id);
        }

        $id_local = Request::get('id');
        if (isset($id_local) && !empty($id_local) && is_numeric($id_local)) {
            $model->where('log_imports.id', '=', $id_local);
        }

        $scheduled_date = Request::get('periodo');
        if (isset($scheduled_date) && !empty($scheduled_date)) {
            $scheduled_date = format_range_to_database($scheduled_date);
            $model->whereBetween('log_imports.created_at', [$scheduled_date[0], $scheduled_date[1]]);
        }

        return $model;
    }
}
