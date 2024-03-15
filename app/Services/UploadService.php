<?php


namespace App\Services;


use Exception;
use Illuminate\Support\Facades\Storage;

class UploadService
{

    /**
     * UploadService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Faz upload de arquivo independente do tipo
     * @param $arquivo
     * @param $path
     * @param bool $name_original
     * @return string|null
     */

    public function
    uploadS3($arquivo, $path, $name_original = false)
    {

        try {

            $archivePath = "temp/";
            if ($name_original) {
                $fileName = $name_original . "." . $arquivo->getClientOriginalExtension();
            } else {
                $fileName = md5(date("Y_m_d_h_i_s")) . "." . $arquivo->getClientOriginalExtension();
            }
            $path_temp = $archivePath . $fileName;
            $arquivo->move($archivePath, $fileName);
            $s3Client = Storage::disk('s3');
            $cert_name = env("S3_PATH") . $path . "/" . $fileName;

            if (\File::exists($path_temp)) {
                $contents = \File::get($path_temp);
                $s3Client->put($cert_name, $contents);
                \File::delete($path_temp);
                return $s3Client->url($cert_name);
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }

    public function uploadImagemBase64S3($image64, $occurrence_id, $identificador = null)
    {

        $s3Client = Storage::disk('s3');

        $error = array();

        $datetime = date("Ymd_His");

        $output_file_tmp = storage_path() . "/app/" . $datetime . "_" . $identificador . ".jpg";
        $image_name = env("S3_PATH") . get_contractor_to_s3() . "images/occurrences/" . $occurrence_id . "/" . $datetime . "_" . $identificador . ".jpg";

        $img_tmp = $this->base64ToImage($image64, $output_file_tmp);

        if (\File::exists($img_tmp)) {
            $contents = \File::get($img_tmp);
            $s3Client->put($image_name, $contents);
            \File::delete($img_tmp);
            $url = $s3Client->url($image_name);

        } else {
            $error[] = "O arquivo " . $identificador . " -> " . $img_tmp . " não pode ser salvo ou não existe localmente";
        }

        if (count($error) > 0) {
            return $error;
        } else {
            return $url;
        }

    }

    /**
     * Verifica o tamanho do arquivo e retorna uma Exception caso o
     * arquivo ultapasse o tamanho de 10 mb
     * @param $file
     */
    public function fileSize($file)
    {
       if($file->getSize() > 10485760){
           throw new Exception("Tamanho do arquivo maiaor que o permitido (10MB)");
       }
       return true;
    }

}
