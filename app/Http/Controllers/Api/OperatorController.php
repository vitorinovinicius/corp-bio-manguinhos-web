<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\ContractorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\OperatorService;

class OperatorController extends Controller
{
    /**
     * @var OperatorService
     */
    private $operatorService;

    public function __construct(OperatorService $operatorService)
    {
        $this->operatorService = $operatorService;
    }

    public function updateLocation(Request $request){
        return $this->operatorService->updateLocation($request);
    }

    public function verifyIsOperator(){
        if (!Auth::guard('api')->check()) {
            $arrayError = array("data" => array("error" => "Erro na autenticação"));

            return $arrayError;
        }

        $user = Auth::guard('api')->user();

        /**
         * Pegar dados do supervidor do oeprador
         */
        $supervisor = null;

        $team = $user->teams->first();

        if(!$user->hasRole('operator')){
            $arrayError = array("data" => array("error" => "Usuário não é um operador"));

            return $arrayError;
        }
        if($user->status != 1){
            $arrayError = array("data" => array("error" => "Usuário não tem mais acesso ao sistema"));

            return $arrayError;
        }
        if($team != null){
            $hasSupervisor = $team->users()->wherePivot('is_supervisor',1)->first();
            if($hasSupervisor != null){
                $supervisor = $hasSupervisor->name;
            }
        }


        $array = array("data" => array("success" => true,"supervisor"=>$supervisor, "team_name" => $team->name, "operator"=>$user , "contractor" => new ContractorResource($user->contractor)));

        return $array;
    }

    public function saveMove(Request $request){
        return $this->operatorService->saveMove($request);
    }

    public function updateProfile(Request $request){
        return $this->operatorService->updateProfile($request);
    }
}
