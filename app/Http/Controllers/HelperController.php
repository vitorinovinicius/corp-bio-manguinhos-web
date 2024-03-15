<?php

namespace App\Http\Controllers;

use App\Repositories\OccurrenceRepository;
use App\Services\OccurrenceImageService;

class HelperController extends Controller
{

    private $occurrenceRepository;
    private $occurrenceImageService;

    public function __construct(OccurrenceRepository $occurrenceRepository,OccurrenceImageService $occurrenceImageService)
    {
        $this->occurrenceRepository = $occurrenceRepository;
        $this->occurrenceImageService = $occurrenceImageService;
    }

    public function getAddressToCepRepulica($cep){

        $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=json');
        if(!$resultado){
            $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
        }
        parse_str($resultado, $retorno);

        return $resultado;
    }

    public function rotate(){
        return $this->occurrenceImageService->rotate270();
    }
}
