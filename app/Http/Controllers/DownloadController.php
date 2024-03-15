<?php

namespace App\Http\Controllers;


use App\Repositories\OccurrenceImageRepository;
use App\Repositories\OccurrenceArchiveRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
    /**
     * @var OccurrenceImageRepository
     */
    private $occurrenceImageRepository;

     /**
     * @var OccurrenceArchiveRepository
     */
    private $occurrenceArchiveRepository;

    public function __construct(OccurrenceImageRepository $occurrenceImageRepository, OccurrenceArchiveRepository $occurrenceArchiveRepository)
    {
        $this->occurrenceImageRepository = $occurrenceImageRepository;
        $this->occurrenceArchiveRepository = $occurrenceArchiveRepository;
    }

    public function downloadAnexosByOs(Request $request){
        $data = $request->all();
        if(!isset($data["occurrence_id"]) || empty($data["occurrence_id"])){
            return response()->json([
                'retorno' => 2,
                'mensagem' => 'Parâmetros inválidos'
            ]);
        }
        $occurrence_id = $data["occurrence_id"];

        $occurrenceAnexos = $this->occurrenceArchiveRepository->findWhere(["occurrence_id"=>$occurrence_id]);
        if(count($occurrenceAnexos)>0){
            $zipper = new \Chumper\Zipper\Zipper;

            //Verifico se o arquivo existe
            if(is_file('export_anexos.zip')){
                unlink('export_anexos.zip');
            }

            //cria o zip
            try {
                $zipper->make('export_anexos.zip');

            //Cria a pasta tempor[aria]
            $dir = "temp_".str_random(5)."/";
            is_dir($dir) || @mkdir($dir) || die("Não pode criar a pasta");

            //Adiciona as imagens
            foreach ($occurrenceAnexos as $oi){

                $url = $oi->url;
                $title = pathinfo($url,PATHINFO_FILENAME );
                $extension = pathinfo($url, PATHINFO_EXTENSION);

                $filename = str_slug($title).'.'. $extension;

                copy($url, $dir . DIRECTORY_SEPARATOR . $filename);

                $file = glob($dir.'/'.$filename);
                $zipper->add($file);
            }
            $zipper->close();

            if (is_dir($dir)) {
                //remove a pasta temporária
                $this->rmdir_recursive($dir);
            }

//            return Response::download('export_images.zip');
            return 1;
            } catch (\Exception $e) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => 'Erro ao tentar baixar o anexo',
                    'exception' => $e->getMessage()
                ]);
            }

        }else{
//            return "Não há imagens para baixar";
            return response()->json([
                'retorno' => 2,
                'mensagem' => 'Não há anexos para baixar'
            ]);
        }

    }

    public function downloadImageByOs(Request $request)
    {
        $data = $request->all();
        if(!isset($data["occurrence_id"]) || empty($data["occurrence_id"])){
            return response()->json([
                'retorno' => 2,
                'mensagem' => 'Parâmetros inválidos'
            ]);
        }
        $occurrence_id = $data["occurrence_id"];

        $occurrenceImages = $this->occurrenceImageRepository->findWhere(["occurrence_id"=>$occurrence_id]);
        
        if(count($occurrenceImages)>0){
            $zipper = new \Madnest\Madzipper\Madzipper;

            //Verifico se o arquivo existe
            if(is_file('export_images.zip')){
                unlink('export_images.zip');
            }

            //cria o zip
            try {
                $zipper->make('export_images.zip');

            //Cria a pasta tempor[aria]
            $dir = "temp_".str_random(5)."/";
            is_dir($dir) || @mkdir($dir) || die("Não pode criar a pasta");

            //Adiciona as imagens
            foreach ($occurrenceImages as $oi){

                $url = $oi->url;
                $title = pathinfo($url,PATHINFO_FILENAME );
                $extension = pathinfo($url, PATHINFO_EXTENSION);

                $filename = str_slug($title).'.'. $extension;

                copy($url, $dir . DIRECTORY_SEPARATOR . $filename);

                $file = glob($dir.'/'.$filename);
                $zipper->add($file);
            }
            $zipper->close();

            if (is_dir($dir)) {
                //remove a pasta temporária
                $this->rmdir_recursive($dir);
            }

//            return Response::download('export_images.zip');
            return 1;
            } catch (\Exception $e) {
                return response()->json([
                    'retorno' => 2,
                    'mensagem' => 'Erro ao tentar baixar a imagem',
                    'exception' => $e->getMessage()
                ]);
            }

        }else{
//            return "Não há imagens para baixar";
            return response()->json([
                'retorno' => 2,
                'mensagem' => 'Não há imagens para baixar'
            ]);
        }
    }

    public function downloadTest(){
        $zipper = new \Chumper\Zipper\Zipper;

        //Verifico se o arquivo existe
        if(is_file('export_images.zip')){
            unlink('export_images.zip');
        }

        try {
            $zipper->make('export_images.zip');


        $url ='https://s3-sa-east-1.amazonaws.com/centralsystem2/centralmob/ceg/images/occurrences/23/20170524_195935_abrigo_medidores_area_comum.jpg';

        $title = 'Imagem';
        $extension = pathinfo($url, PATHINFO_EXTENSION);

        $filename = str_random(4).'_'.str_slug($title).'.'. $extension;
        $dir = "temp_".str_random(5)."/";
        is_dir($dir) || @mkdir($dir) || die("Não pode criar a pasta");
        copy($url, $dir . DIRECTORY_SEPARATOR . $filename);

        $files = glob($dir.'*');
        $zipper->add($files);
        $zipper->close();

        if (is_dir($dir)) {
//            rmdir('images_temp');
            $this->rmdir_recursive($dir);
        }

        return Response::download('export_images.zip');
        } catch (\Exception $e) {
            return "Erro ao gerar o arquivo zipado. <br>Exception: ".$e->getMessage();
        }
    }

    private function rmdir_recursive($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }
}
