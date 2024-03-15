<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30/07/2019
 * Time: 17:03
 */

namespace App\Services;

use Exception;
use Sms;
use SmsFacade;

class ZenviaSmsService
{
    public function enviaSmsTeste()
    {
        $smsFacade = new SmsFacade(env('ZENVIA_ACCOUNT'), env('ZENVIA_PASSWORD'));
        $sms = new Sms();
        $sms->setTo("5521986610238");
        $sms->setMsg("Este e um teste de envio de mensagem simples utilizando a api php.");
        $sms->setId(uniqid());
        $sms->setCallbackOption(Sms::CALLBACK_NONE);

        try{
            //Envia a mensagem para o webservice e retorna um objeto do tipo SmsResponse com o status da mensagem enviada
            $response = $smsFacade->send($sms);

            echo "Status: ".$response->getStatusCode() . " - " . $response->getStatusDescription();
            echo "<br />Detalhe: ".$response->getDetailCode() . " - " . $response->getDetailDescription();

            if($response->getStatusCode()!="00"){
                echo "<br />Mensagem não pôde ser enviada.";
            }

        }
        catch(Exception $ex){
            echo "Falha ao fazer o envio da mensagem. Exceção: ".$ex->getMessage()."<br />".$ex->getTraceAsString();
        }
    }

    public function enviaSms($data)
    {
        try{

            $smsFacade = new SmsFacade(env('ZENVIA_ACCOUNT'), env('ZENVIA_PASSWORD'));
            $sms = new Sms();
            $sms->setTo($data["telefone"]);
            $sms->setMsg($data["mensagem"]);
            $sms->setId($data["occurrence_id"]);
            $sms->setCallbackOption(Sms::CALLBACK_NONE);
            $retorno = $smsFacade->send($sms);

            $response = ['status' => $retorno->getStatusCode(),
                        'status_detalhe' => $retorno->getStatusDescription(),
                        'status_motivo' => $retorno->getDetailDescription()];
                //Envia a mensagem para o webservice e retorna um objeto do tipo SmsResponse com o status da mensagem enviada
                return ['status'=>1, 'response' => $response];
            }
        catch(Exception $ex){
            return ['status'=>2, 'message'=>$ex->getMessage()];
        }
    }
}