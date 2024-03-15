<?php
/**
 * Created by PhpStorm.
 * User: Lucas Maia
 * Date: 27/09/2017
 * Time: 13:43
 */

namespace App\Services;

use App\Repositories\AppVersionRepository;
use Request;
use Storage;


class AppService
{
    private $appVersionRepository;

    public function __construct(AppVersionRepository $appVersionRepository)
    {
        $this->appVersionRepository = $appVersionRepository;
    }

    public function salvarStatus($appVersion, $status)
    {
        $appVersion->status = $status;

        $appVersion->save();

        return redirect()->route('app_versions.index')->with('message', 'Ataulizado com sucesso.');
    }

    public function download($version)
    {
        $appVersion = $this->appVersionRepository->findWhere(["version_name" => $version, "status" => 1])->first();

        if ($appVersion) {
            return redirect($appVersion->apk_url);
        }
    }

    public function salvarApk($request)
    {
        ini_set('max_execution_time', 600); //10 minutos
        ini_set('max_input_time', 600);
        ini_set('memory_limit', 512);

        $input = $request->all();

//        $apk = Request::input('apk');
        $apk = $request->apk;

        if($apk->getClientMimeType() != "application/vnd.android.package-archive"){
            return redirect()->back()->withInput()->with('error','Arquivo diferente do permitido');
        }

        /*
        * GRAVAR S3
        */

        try {

            $fileName = "app_"  . $input["version_code"] . "_" . date("Ymdhi") . ".apk";

            $fileNameUrl = env("S3_PATH") . get_contractor_to_s3() . "apps/" . $fileName;
            $s3Client = Storage::disk('s3');
            $s3Client->put($fileNameUrl, \File::get($apk));
            \File::delete($apk);
            $url = $s3Client->url($fileNameUrl);

            $input["apk"] = $fileName;
            $input["apk_url"] = $url;

            $this->appVersionRepository->create($input);

            return redirect()->route('app_versions.index')->with('message', 'Aplicativo cadastrado com sucesso.');

        } catch (\Exception $e) {
            //rollback
            if ($e->getCode() == "23000") {
                return redirect()->route('app_versions.index')->with('error', "Código da versão duplicado.");
            } else {
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }

        }
    }

    public function listaAppVersion()
    {
        return $this->appVersionRepository->paginate();
    }

    public function latestVersion()
    {
        $appVersion = $this->appVersionRepository->findWhere(["status"=>1])->last();

        if ($appVersion) {
            return redirect($appVersion->apk_url);
        }else{
            return "Não há versão liberada!";
        }

    }

    public function atualizaApp($currentVersion)
    {
        $appVersion = $this->appVersionRepository->findWhere(["status"=>1])->last();

        if ($appVersion) {
            if (version_compare($appVersion->version_name, $currentVersion) > 0) {
                return response()->json(["success" => true, "message" => "", "url" => $appVersion->apk_url]);
            }
        }

        return response()->json(["success" => false, "message" => "Sua versão já está atualizada"]);
    }

    public function destroy($app_version)
    {
        $s3Client = Storage::disk('s3');
        $path = env("S3_PATH") . get_contractor_to_s3() . "apps/" . $app_version->apk;

        try {
            if ($s3Client->exists($path)) {
                $s3Client->delete($path);
            }
            $app_version->delete();
            return redirect()->route('app_versions.index')->with('message', 'Item deletado com sucesso.');

        } catch (\Exception $e) {
            return redirect()->route('app_versions.index')->with('error', 'Erro ao remover o arquivo do Servidor');
        }

    }

}
