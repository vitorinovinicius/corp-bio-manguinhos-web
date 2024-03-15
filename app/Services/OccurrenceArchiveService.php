<?php


namespace App\Services;


use App\Repositories\OccurrenceArchiveRepository;
use App\Services\UploadService;
use Illuminate\Support\Facades\Auth;

class OccurrenceArchiveService
{
    /**
     * @var OccurrenceArchiveRepository
     */
    private $occurrenceArchiveRepository;
    /**
     * @var \App\Services\UploadService
     */
    private $uploadService;

    /**
     * OccurrenceArchiveService constructor.
     * @param OccurrenceArchiveRepository $occurrenceArchiveRepository
     */
    public function __construct(OccurrenceArchiveRepository $occurrenceArchiveRepository, UploadService $uploadService)
    {
        $this->occurrenceArchiveRepository = $occurrenceArchiveRepository;
        $this->uploadService = $uploadService;

    }

    public function addAnexoOs($request)
    {

        if(isset($request['anexos'])){
            $anexos = $request['anexos'];
        } else {
            return redirect()->back()->with('error', 'Não pode localizar os anexos');
        }

        $occurrence = $request["occurrence"];
        $occurrenceUuid = $request["occurrence_uuid"];

        $path = "anexo/occurrences/". $occurrence;

        $error = array();

        try{

            foreach ($anexos as $anexo){
                if($this->uploadService->fileSize($anexo)){
                    $data['occurrence_id'] = $occurrence;
                    $data['user_id'] = Auth::user()->id;
                    $data['name_original'] = $anexo->getClientOriginalName();
                    $data['name'] = retira_acentos_espacos(pathinfo($anexo->getClientOriginalName(), PATHINFO_FILENAME));
                    $data['size'] = $anexo->getSize();
                    $data['type_file'] = $anexo->getClientMimeType();
                    $url = $this->uploadService->uploadS3($anexo, $path, $data['name']);

                    if($url != null){
                        $data['url'] = $url;
                    } else {
                        $error[] = "O arquivo " .$anexo->getClientOriginalName() . " não pode ser salvo ";
                        continue;
                    }

                    $this->occurrenceArchiveRepository->create($data);
                } else {
                    $error[] = "O arquivo " .$anexo->getClientOriginalName() . " não pode ser salvo ";
                }
            }

            if(count($error) == 0){
                return redirect()->route('occurrences.show', $occurrenceUuid)->with('message', 'Item atualizado com sucesso.');
            }else {
                return redirect()->route('occurrences.show', $occurrenceUuid)->with('error', compact('error'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->with("error","Erro na tentativa de inclusão de arquivo: " .$e->getMessage())->withInput();
        }

    }

    public function deleteArchive($archives)
    {
        try{
            $this->occurrenceArchiveRepository->delete($archives->id);
            return redirect()->back()->with('message', 'Item excluído com sucesso.')->withInput();
        }catch(\Exception $e){
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Erro ao excluir o arquivo. Erro: ' . $e->getMessage())->withInput();
        }
    }
}
