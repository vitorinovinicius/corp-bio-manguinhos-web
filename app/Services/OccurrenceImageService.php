<?php
/**
 * Created by PhpStorm.
 * User: CELTAPHP
 * Date: 19/12/2016
 * Time: 11:28
 */

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Storage;
use App\Repositories\OccurrenceImageRepository;

class OccurrenceImageService
{

    /**
     * @var OccurrenceImageRepository
     */
    private $occurrenceImageRepository;

    public function __construct(
        OccurrenceImageRepository $occurrenceImageRepository
    )
    {
        $this->occurrenceImageRepository = $occurrenceImageRepository;
    }

    public function uploadImagemS3($array_image, $occurrence_id){

        $s3Client = Storage::disk('s3');

        $error = array();
        foreach ($array_image as $key=>$value){

            $datetime = date("Ymd_His");
            $output_file_tmp = storage_path()."/app/".$datetime."_".$key.".jpg";
            $image_name = env("S3_PATH"). get_contractor_to_s3() ."images/occurrences/".$occurrence_id."/".$datetime."_".$key.".jpg";

            $img_tmp = $this->base64ToImage($value,$output_file_tmp);

            if (\File::exists($img_tmp)){
                $contents = \File::get($img_tmp);
                $s3Client->put($image_name, $contents);
                \File::delete($img_tmp);
                $url = $s3Client->url($image_name);

                $this->saveOccurrenceImage($url,$occurrence_id,$key);
            }else{
                $error[] = "O arquivo número ".$key." -> ".$img_tmp." não pode ser salvo ou não existe localmente";
            }
        }

        if(count($error) > 0){
            return $error;
        }else{
            return 1;
        }
    }
    public function newUploadImagemS3($array_image, $occurrence_id){

        $s3Client = Storage::disk('s3');
        $error = array();
        foreach ($array_image as $key=>$imagens) {
            if(is_array($imagens)){
                foreach ($imagens as $value) {
                    if (!empty($value)) {
                        $datetime = date("Ymd_His");
                        $output_file_tmp = storage_path() . "/app/" . $datetime . "_" . $key . ".jpg";
                        $image_name = env("S3_PATH"). get_contractor_to_s3() ."images/occurrences/" . $occurrence_id . "/" . $datetime . "_" . $key . ".jpg";

                        $img_tmp = $this->base64ToImage($value, $output_file_tmp);

                        if (\File::exists($img_tmp)) {
                            $contents = \File::get($img_tmp);
                            $s3Client->put($image_name, $contents);
                            \File::delete($img_tmp);
                            $url = $s3Client->url($image_name);

                            $this->saveOccurrenceImage($url, $occurrence_id, $key);
                        } else {
                            $error[] = "O arquivo número " . $key . " -> " . $img_tmp . " não pode ser salvo ou não existe localmente";
                        }
                    }
                }
            }
        }

        if(count($error) > 0){
            return $error;
        }else{
            return 1;
        }
    }

    public function uploadUniqueImagemS3($image64, $occurrence_id,$identificador=null){

        $s3Client = Storage::disk('s3');

        $error = array();

        $datetime = date("Ymd_His");
        $output_file_tmp = storage_path()."/app/".$datetime."_".$identificador.".jpg";
        $image_name = env("S3_PATH"). get_contractor_to_s3() ."images/occurrences/".$occurrence_id."/".$datetime."_".$identificador.".jpg";

        $img_tmp = $this->base64ToImage($image64,$output_file_tmp);

        if (\File::exists($img_tmp)){
            $contents = \File::get($img_tmp);
            $s3Client->put($image_name, $contents);
            \File::delete($img_tmp);
            $url = $s3Client->url($image_name);

        }else{
            $error[] = "O arquivo ".$identificador." -> ".$img_tmp." não pode ser salvo ou não existe localmente";
        }

        if(count($error) > 0){
            return $error;
        }else{
            return $url;
        }

    }

    public function uploadSimpleUniqueImagemS3($img_tmp, $occurrence_id,$identificador=null){

        $s3Client = Storage::disk('s3');

        $error = array();

        $datetime = date("Ymd_His");
        $image_name = env("S3_PATH"). get_contractor_to_s3() ."images/occurrences/".$occurrence_id."/".$datetime."_".$identificador.".jpg";

        if (\File::exists($img_tmp)){
            $contents = \File::get($img_tmp);
            $s3Client->put($image_name, $contents);
            \File::delete($img_tmp);
            $url = $s3Client->url($image_name);

        }else{
            $error[] = "O arquivo ".$identificador." -> ".$img_tmp." não pode ser salvo ou não existe localmente";
        }

        if(count($error) > 0){
            return $error;
        }else{
            return $url;
        }

    }

    private function saveOccurrenceImage($url,$occurrence_id,$reference=null){
        $data["occurrence_id"] = $occurrence_id;
        $data["url"] = $url;
        $data["reference"] = $reference;
        return $this->occurrenceImageRepository->create($data);
    }
    public function saveOccurrenceImagePublic($url,$occurrence_id,$reference=null){
        $data["occurrence_id"] = $occurrence_id;
        $data["url"] = $url;
        $data["reference"] = $reference;
        return $this->occurrenceImageRepository->create($data);
    }

    private function base64ToImage($base64_string, $output_file)
    {
        $file = fopen($output_file, "wb");

        fwrite($file, base64_decode($base64_string));

        fclose($file);

        return $output_file;
    }

    public function rotate270(){
        $pathImagem = $_POST["image"];
        $rotate = $_POST["rotate"];
        $s3Client = Storage::disk('s3');

        $img = Image::make($pathImagem);
        $img->rotate($rotate);
        $img_tmp = public_path("temp.jpg");
        $img->save($img_tmp);

        $image_name = str_replace("https://s3-sa-east-1.amazonaws.com/centralsystem2/","",$pathImagem);

        if (\File::exists($img_tmp)){
            //Deleta imagem do S3
            $s3Client->delete($pathImagem);

            $contents = \File::get($img_tmp);
            $s3Client->put($image_name, $contents);
            \File::delete($img_tmp);

            return array("retorno"=>1);
        }else{
            return array("retorno"=>2,"erro"=>"O arquivo não pode ser salvo ou não existe localmente");
        }
    }

    public function uniqueNewUploadImagemS3($array_image){

        $user = Auth::user();

        $pathLog = "logs_json/";
        $nameFileUser = "image_log_json_" . date("Ymd") . ".log";

        $s3Client = Storage::disk('s3');
        $occurrence_id = $array_image["occurrence_id"];


        $reference = $array_image["reference"];
        $imagem    = $array_image["imagem"];
        $datetime        = date("Ymd_His");
        $output_file_tmp = storage_path() . "/app/" . $datetime . "_" . $reference . ".jpg";
        $image_name      = env("S3_PATH"). get_contractor_to_s3() ."images/occurrences/" . $occurrence_id . "/" . $datetime . "_" .          $reference . ".jpg";


        if(empty($occurrence_id)) {

            file_put_contents($pathLog . "/" . $nameFileUser,"USER: " . $user->id . "ERRO: $image_name" . "\n", FILE_APPEND);

            return array("status"=>2, "mensagem"=>"Occurrence não enviada");
        }

        $loggArray = [
            'occurrence_id' => $occurrence_id,
            'reference' => $reference
        ];

        $img_tmp = $this->base64ToImage($imagem, $output_file_tmp);

        if (\File::exists($img_tmp)) {
            $contents = \File::get($img_tmp);
            $s3Client->put($image_name, $contents);
            \File::delete($img_tmp);
            $url = $s3Client->url($image_name);

            $loggArray['url'] = $url;

            $this->saveOccurrenceImage($url, $occurrence_id, $reference);

            file_put_contents($pathLog . "/" . $nameFileUser,json_encode($loggArray) . "\n", FILE_APPEND);

            return array("status"=>1, "mensagem"=>$url);
        } else {

            $loggArray['tmp'] = $img_tmp;
            file_put_contents($pathLog . "/" . $nameFileUser,json_encode($loggArray), FILE_APPEND);

            return array("status"=>2, "mensagem"=>"O arquivo número " . $reference . " -> " . $img_tmp . " não pode ser salvo ou não existe localmente");
        }
    }

}
