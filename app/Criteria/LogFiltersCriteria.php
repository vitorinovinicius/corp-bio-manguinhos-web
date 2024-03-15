<?php

namespace App\Criteria;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LogFiltersCriteria
 * @package namespace Lwd\Criteria;
 */
class LogFiltersCriteria implements CriteriaInterface
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function apply($model, RepositoryInterface $repository)
    {
        //exam_date no banco está yyyy-mm-dd
        $user_id = $this->request->get('user_id');
        $action = $this->request->get('action');
        $description = $this->request->get('description');
        $date_range = $this->request->get('date_range');
        if(isset($date_range) && !empty($date_range)){
            $date_range = explode(" - ",$date_range);
            $date_start = Carbon::createFromFormat("d/m/Y H",$date_range[0].' 0');
            $date_end = Carbon::createFromFormat("d/m/Y H:i:s",$date_range[1].' 23:59:59');
        }

        if(isset($user_id) && !empty($user_id)){
            $model->where('causer_id', '=', $user_id);
        }

        if(isset($description) && !empty($description)){
            $model->where('description','LIKE', '%'.$description.'%');
        }
        if(isset($action) && !empty($action)){
            $model->where('log_name', 'LIKE', $action.'%');
        }

        if(isset($date_range) && !empty($date_range)){
            $model->whereBetween('created_at', array($date_start,$date_end));
        }


        return $model;
    }
}
