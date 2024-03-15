<?php
/**
 * Created by PhpStorm.
 * User: CELTAPHP
 * Date: 19/12/2016
 * Time: 11:28
 */

namespace App\Services\Api;

use App\Repositories\OccurrenceArchiveRepository;
use App\Repositories\OccurrenceRepository;
use App\Services\MailService;
use Storage;
use App\Repositories\OccurrenceImageRepository;use Illuminate\Http\Request;


class OccurrenceImageService
{

    /**
     * @var OccurrenceImageRepository
     */
    private $occurrenceImageRepository;

    /**
     * @var OccurrenceRepository
     */
    private $occurrenceRepository;
    /**
     * @var MailService
     */
    private $mailService;
    /**
     * @var OccurrenceArchiveRepository
     */
    private $occurrenceArchiveRepository;

    /**
     * OccurrenceImageService constructor.
     * @param OccurrenceImageRepository $occurrenceImageRepository
     * @param OccurrenceRepository $occurrenceRepository
     * @param MailService $mailService
     * @param OccurrenceArchiveRepository $occurrenceArchiveRepository
     */
    public function __construct(
        OccurrenceImageRepository $occurrenceImageRepository,
        OccurrenceRepository $occurrenceRepository,
        MailService $mailService,
        OccurrenceArchiveRepository $occurrenceArchiveRepository
    )
    {
        $this->occurrenceImageRepository = $occurrenceImageRepository;
        $this->occurrenceRepository = $occurrenceRepository;
        $this->mailService = $mailService;
        $this->occurrenceArchiveRepository = $occurrenceArchiveRepository;
    }

    public function saveAudio($request){

        try {
            $uuid = $request->input("uuid");
            $reference = $request->input("reference");
            $archive = $request->input("image");
            $occurrenceId = $request->input("occurrence_id");

            $occurrence = $this->occurrenceRepository->find($occurrenceId);
            $occurrenceFile = $this->occurrenceArchiveRepository
                ->findWhere(['external_uuid' => $uuid, 'type_file' => 1])
                ->first();

            if ($occurrenceFile) {
                return response()->json(['message' => "Audio já existe"]);
            }

            $userId = \Auth::user()->getAuthIdentifier();

            if (!$userId) {
                return response()->json(['message' => "Usuário não esta logado"]);
            }

            $s3Client = Storage::disk('s3');
            $datetime = date("Ymd_His");


            $output_file_tmp = storage_path() . "/app/" . $datetime . "_" . $reference . ".mp3";
            $image_name = env("S3_PATH") . get_contractor_to_s3() . "audios/occurrences/" .
                $occurrenceId . "/" . $datetime . "_" .
                $reference . ".mp3";

            $img_tmp = $this->base64ToImage($archive, $output_file_tmp);

            if (\File::exists($img_tmp)) {

                $contents = \File::get($img_tmp);
                $s3Client->put($image_name, $contents);
                \File::delete($img_tmp);
                $url = $s3Client->url($image_name);

                $data["uuid_external"] = $uuid;
                $data["url"] = $url;
                $data["occurrence_id"] = $occurrenceId;
                $data["user_id"] = $userId;
                $data["type_file"] = 1;
                $data["name_original"] = "Assinatura do Cliente (Audio)";

                $this->occurrenceArchiveRepository->create($data);

                $occurrence->signature_type = "AUDIO_ASSINATURA";
                $occurrence->save();

            } else {
                return response()->json(['message' => "O arquivo número " . $reference .
                    " -> " . $img_tmp .
                    " não pode ser salvo ou não existe localmente"], 500);
            }

            if ($occurrence->occurrence_images->count() == $occurrence->total_imagens) {
                if ($occurrence->occurrence_data_client->cliente_recebe_email == 1) {
                    $this->mailService->envia_os_completa($occurrence);
                }
            }

            return response()->json(['url' => $url], 200);

        }catch (\Exception $exception) {
            return response()->json(['erro' => $exception->getMessage()], 500);

        }
    }
    public function uniqueNewUploadImagemS3(Request $request){

        $pathLog = "logs/";
        $nameLogRequest = "image_log_request_json_" . date("Ymd") . ".log";

        if(!$request->input("image")) {
            gera_log($pathLog, $nameLogRequest, "UPLOAD IMAGEM - Não existe imagem");

            return response()->json(['message'=>"Não existe imagem"], 500);
        }

        if(!$request->input("occurrence_id")) {
            gera_log($pathLog, $nameLogRequest, "UPLOAD IMAGEM - Occurrence não enviada");
            return response()->json(['message'=>"Occurrence não enviada"], 500);
        }


        $inputImageLog = $request->all();
        $inputImageLog['image'] = null;

        if (env('GERA_LOG_REQUEST') == 1) {
            gera_log($pathLog, $nameLogRequest, $inputImageLog);
        }

        $uuid            = $request->input("uuid");
        $reference       = $request->input("reference");
        $imagem          = $request->input("image");
        $occurrenceId    = $request->input("occurrence_id");
        $numAparelho     = $request->input("num_aparelho");
        $formId          = $request->input("form_id");
        $formFieldId     = $request->input("form_field_id");
        $position        = $request->input("position");

        if ($reference == "AUDIO_ASSINATURA") {
            return $this->saveAudio($request);
        }

        $referenceNameImage = trim($reference);
        $referenceNameImage = preg_replace(array(
            "/(á|à|ã|â|ä)/",
            "/(Á|À|Ã|Â|Ä)/",
            "/(é|è|ê|ë)/",
            "/(É|È|Ê|Ë)/",
            "/(í|ì|î|ï)/",
            "/(Í|Ì|Î|Ï)/",
            "/(ó|ò|õ|ô|ö)/",
            "/(Ó|Ò|Õ|Ô|Ö)/",
            "/(ú|ù|û|ü)/",
            "/(Ú|Ù|Û|Ü)/",
            "/(ñ)/",
            "/(Ñ)/",
            "/(Ç|ç)/",
            "/( |\/)/",
            "/\./",
            "/(-)/",
            "/(__)/",
            "/(º)/",
            "/(0|1|2|3|4|5|6|7|8|9)/"
        ), explode(" ", "a a e e i e o o u u n n c _  _   "), $referenceNameImage);

        /**
         * Gravacao normal de imagem
         */

        $occurrence = $this->occurrenceRepository->find($occurrenceId);

        $occurrenceImage = $this->occurrenceImageRepository->findWhere(['uuid_external' => $uuid])->first();

        if($occurrenceImage) {
            return response()->json(['message' => "Imagem já existe"]);
        }

        $s3Client = Storage::disk('s3');

        $datetime        = date("Ymd_His");

        $output_file_tmp = storage_path() . "/app/" . $datetime . "_" . $referenceNameImage . ".jpg";
        $image_name = env("S3_PATH") . get_contractor_to_s3() . "images/occurrences/" . $occurrenceId . "/" . $datetime . "_" . $referenceNameImage . ".jpg";


        $img_tmp = $this->base64ToImage($imagem, $output_file_tmp);

        if (\File::exists($img_tmp)) {

            $contents = \File::get($img_tmp);
            $s3Client->put($image_name, $contents);
            \File::delete($img_tmp);
            $url = $s3Client->url($image_name);

            $this->saveOccurrenceImage($url, $occurrenceId, $reference, $uuid, $formId,$formFieldId, $position);

        } else {
            gera_log($pathLog, $nameLogRequest, "UPLOAD IMAGEM - " . "O arquivo número " . $reference . " -> " . $img_tmp . " não pode ser salvo ou não existe localmente");

            return response()->json(['message' => "O arquivo número " . $reference .
                " -> " . $img_tmp .
                " não pode ser salvo ou não existe localmente"], 500);
        }

        if($occurrence->occurrence_images->count() == $occurrence->total_imagens){
            if ($occurrence->occurrence_data_client->cliente_recebe_email == 1) {
                $this->mailService->envia_os_completa($occurrence);
            }
        }

        return response()->json(['url' => $url], 200);

    }

    private function saveOccurrenceImage($url,$occurrence_id,$reference=null, $uuid=null, $formId=null, $formFieldId=null, $position = null){

        $data["occurrence_id"]     = $occurrence_id;
        $data["uuid_external"]     = $uuid;
        $data["url"]               = $url;
        $data["reference"]         = $reference;
        $data["form_id"]           = $formId;
        $data["form_field_id"]     = $formFieldId;
        $data["position"]          = $position;

        return $this->occurrenceImageRepository->create($data);
    }
    private function base64ToImage($base64_string, $output_file)
    {
        $file = fopen($output_file, "wb");

        fwrite($file, base64_decode($base64_string));

        fclose($file);

        return $output_file;
    }
}
