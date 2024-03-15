<?php

namespace App\Criteria;

use Artesaos\Defender\Facades\Defender;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OperatorSelectCriteria
 * @package namespace App\Criteria;
 */
class OperatorSelectCriteria implements CriteriaInterface
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
        $scheduled_date = Request::get('scheduled_date');

        $model = $model
//            ->with(['teams','vehicle','contractor', 'occurrences', 'move'])
            ->selectRaw('users.*')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('user_team', 'users.id', '=', 'user_team.user_id')
            ->where('role_user.role_id', 4);

        //Mostra apenas os supervisores do supervisor, caso ele esteja logado
        if (Defender::is('supervisor') AND !Defender::is('admin')) {
            if (\Auth::user()->teams()->wherePivot('is_supervisor', 1)->first()) {
                $team_id = \Auth::user()->teams()->wherePivot('is_supervisor', 1)->first()->id;
                $model->where('user_team.team_id', $team_id);
            } else {
                $model->where('user_team.team_id', 1514566514654); //Para não aparecer nada
            }
        }

        $name = Request::get('name');
        if (isset($name) && !empty($name)) {
            $model->where('users.name', 'LIKE', '%' . $name . '%');
        }

        $device_version = Request::get('device_version');
        if (isset($device_version) && !empty($device_version)) {
            $model->where('users.device_version', 'LIKE', '%' . $device_version . '%');
        }

        $status = Request::get('status');
        if (isset($status) && !empty($status)) {
            $model->where('users.status', $status);
        }

        $team_id = Request::get('team_id');
        if (isset($team_id) && !empty($team_id)) {
            $model->where('user_team.team_id', $team_id);
        }

        $contractor_id = Request::get('contractor_id');
        if (isset($contractor_id) && !empty($contractor_id)) {
            $model->where('users.contractor_id', $contractor_id);
        }

        $detector_de_gas = Request::get('detector_de_gas');
        if (isset($detector_de_gas) && !empty($detector_de_gas)) {
            $model->where('users.detector_de_gas', $detector_de_gas);
        }

        $manometro = Request::get('manometro');
        if (isset($manometro) && !empty($manometro)) {
            $model->where('users.manometro', $manometro);
        }

        $vencimento = Request::get('vencimento');
        if (isset($vencimento) && !empty($vencimento)) {
            $vencimento = format_range_to_database($vencimento);

            $model->whereBetween('users.manometro_validade', [$vencimento[0], $vencimento[1]])->orWhere(function ($query) use ($vencimento) {
                $query->whereBetween('users.analisador_validade', [$vencimento[0], $vencimento[1]]);
            });
        }

        $vencido = Request::get('vencido');

        if (isset($vencido) && !empty($vencido)) {
            $model->where(function($q) {
                $q->where('users.manometro_validade', '<',   \Illuminate\Support\Carbon::now()->format("Y-m-d"))
                    ->orWhere('users.analisador_validade', '<',  \Illuminate\Support\Carbon::now()->format("Y-m-d"));
            });
        }


//        if (isset($scheduled_date) && !empty($scheduled_date)) {
//            $explodData = explode("-", $scheduled_date);
//            $explodDataIni = explode("/", trim($explodData[0]));
//            $explodDataFim = explode("/", trim($explodData[1]));
//
//            $dataIni = $explodDataIni[2] . "-" . $explodDataIni[1] . "-" . $explodDataIni[0];
//            $dataFim = $explodDataFim[2] . "-" . $explodDataFim[1] . "-" . $explodDataFim[0];
//
//            if ($dataIni != "" && $dataFim != "") {
//                $model = $model->join('occurrences', 'occurrences.operator_id', '=','users.id');
//                $model = $model->whereBetween('occurrences.schedule_date', [$dataIni, $dataFim]);
//            }
//        }

        if (
            Route::is("admin.dashboard") ||
            Route::is("admin.monitoring") ||
            Route::is("admin.index") ||
            Route::is("admin.technical") ||
            Route::is("admin.dashboard.ajax") ||
            Route::is("admin.dashboard.technical_maps") ||
            Route::is("admin.dashboard.list")
        ) {
            $model->where('users.status', 1);
        }

        /*
         * Caso seja role regiao pegar apenas tecnicos das empreiteiras que atendem a regiao que posso ver..
         */

        $regionsUser = \Auth::user()->regions->pluck('id')->all();
        $regiaoRole = \Auth::user()->hasRole('regiao');

        if ($regiaoRole) {
            $model->join('region_users', 'users.id', '=', 'region_users.user_id')
                ->whereIn('region_users.region_id', $regionsUser);
        }

        $model->distinct();

        $model->orderBy("users.id", "desc");

        return $model;
    }
}
