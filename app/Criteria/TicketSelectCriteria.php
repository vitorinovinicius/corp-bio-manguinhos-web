<?php

namespace App\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Artesaos\Defender\Facades\Defender;

/**
 * Class TicketSelectCriteria.
 *
 * @package namespace App\Criteria;
 */
class TicketSelectCriteria implements CriteriaInterface
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
        $model = $model->selectRaw('tickets.*');

        $created_at = \Request::get('scheduled_date');
        
        // if ($created_at) {
        //     $explodData = explode("-", $created_at);
        //     $explodDataIni = explode("/", trim($explodData[0]));
        //     $explodDataFim = explode("/", trim($explodData[1]));


        //     $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
        //     $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];

        //     if ($dataIni != "" && $dataFim != "") {
        //         $model->whereBetween(\DB::raw('DATE(created_at)'), [$dataIni, $dataFim]);
        //     } else {
        //         $model->where('tickets.created_at', 'like', '%'.Carbon::now()->format('Y-m-d').'%');
        //     }
        // } else {
        //     $model->where('tickets.created_at', 'like', '%'.Carbon::now()->format('Y-m-d').'%');

        // }

        if(Defender::hasRole('cliente')){
            $user_id  = \Auth::user()->id;
            $model->where('tickets.user_id', $user_id);
        }

        return $model;
    }
}
