<?php


namespace App\Services;

use Storage;
use App\Repositories\ArchiveRepository;

class ArchiveService
{
    private $archiveRepository;

    public function __construct( ArchiveRepository $archiveRepository)
    {
        $this->archiveRepository = $archiveRepository;
    }

    public function create($type, $archive, $pathArchive, $reference)
    {
        $error = array();

        foreach($archive as $archive){
            $archivePath = "temp/";
            $fileName = md5(date("Y_m_d_h_i_s")) . $archive->getClientOriginalName() . "." . $archive->getClientOriginalExtension();
            $path = $archivePath . $fileName;
            $archive->move($archivePath, $fileName);
            $s3Client = Storage::disk('s3');
            $url = env("S3_PATH"). $pathArchive . $fileName;

            if (\File::exists($path)) {
                $contents = \File::get($path);
                $s3Client->put($url, $contents);
                \File::delete($path);
                $url = $s3Client->url($url);

                $this->saveArchive($type, $url, $fileName, $archive->getClientOriginalName(), $reference);
            }else{
                $error[] = "O arquivo número não  pode ser salvo ou não existe localmente";
            }
        }

        return $error;
    }

    public function destroyArchive($request)
    {
        $data = $request->all();
        try {

            $this->archiveRepository->delete($data["id"]);
            return response()->json([
                'retorno' => 1,
                'mensagem' => 'Arquivo apagado com sucesso!'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'retorno' => 2,
                'mensagem' => $e->getMessage()
            ]);
        }
    }

    public function saveArchive($type, $url, $fileName, $name, $reference )
    {
        $data["type"] = $type;
        $data["user_id"] = auth()->user()->id;
        $data["url"] = $url;
        $data["name"] = $fileName;
        $data["original_name"] = $name;
        $data["reference_id"] = $reference;

        return $this->archiveRepository->create($data);
    }

    public function saveArchiveApi($type, $url, $fileName, $name, $reference )
    {
        $data["type"] = $type;
        $data["user_id"] = \Auth::guard('api')->user()->id;
        $data["url"] = $url;
        $data["name"] = $fileName;
        $data["original_name"] = $name;
        $data["reference_id"] = $reference;
        $data["contractor_id"] = \Auth::guard('api')->user()->contractor_id;

        return $this->archiveRepository->create($data);
    }
}
