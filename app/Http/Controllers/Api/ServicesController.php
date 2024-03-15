<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ServicesController extends Controller
{

    public function __construct()
    {
    }

    public function findCep($cep = null)
    {
        if($cep == "") {
            return response()->json(['error'=>true,'message'=>'CEP informado.']);
        }

        try {

            $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep=' . urlencode($cep) . '&formato=json');
            if (!$resultado) {
                $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
            }

            parse_str($resultado, $retorno);

            $resultObject = json_decode($resultado);

            if ($resultObject->resultado == 1) {
                return response($resultado)
                    ->header('Content-Type', 'application/json');
            } else {
                return response()->json(['error'=>true,'message'=>'CEP não encontrado.']);
            }

        } catch (\Exception $exception) {
            return response()->json(['error'=>true,'message'=>'Aconteceu um problema ao efetuar a busca.']);
        }

    }

}
